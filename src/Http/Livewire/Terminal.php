<?php

namespace Jakyeru\LaravelShell\Http\Livewire;

use Illuminate\Support\Str;
use Jakyeru\LaravelShell\Rules\CommandRule;
use Livewire\Component;

class Terminal extends Component
{
    /**
     * The current directory.
     *
     * @var string
     */
    public string $currentDirectory;

    /**
     * The shell that will be used to run commands.
     *
     * @var string
     */
    public string $commandLine;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        config(['livewire.layout' => 'laravel-shell::layouts.app']);
        config(['livewire.class_namespace' => 'Jakyeru\LaravelShell\Http\Livewire']);

        $this->changeDirectory(base_path());
    }

    /**
     * Render the component.
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('laravel-shell::livewire.terminal');
    }

    /**
     * Run a command.
     */
    public function runCommand(string $command): void
    {
        chdir($this->currentDirectory);

        if (Str::startsWith($command, 'cd')) {
            $this->changeDirectory(substr($command, 3));
            return;
        }

        $validator = validator(['command' => $command], [
            'command' => ['required', new CommandRule],
        ]);

        if ($validator->fails()) {
            $this->dispatchBrowserEvent('laravel-shell:terminal-output', ['output' => [$validator->errors()->first()]]);
            return;
        }

        $output = [];

        exec("{$this->commandLine} {$command} 2>&1", $output);

        foreach ($output as $key => $value) {
            $output[$key] = $value . PHP_EOL;
            $output[$key] = trim($value);
        }

        $this->dispatchBrowserEvent('laravel-shell:terminal-output', ['output' => $output]);
    }

    /**
     * Change the current directory.
     */
    public function changeDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            chdir($directory);
            if (php_uname('s') === 'Windows NT') {
                $this->currentDirectory = str_replace('\\', '/', getcwd());
                $this->commandLine = 'powershell.exe -NoLogo -NoProfile -Command "cd ' . $this->currentDirectory . '; $host.ui.RawUI.WindowTitle = \'Laravel Shell\';"';
            } else if (php_uname('s') === 'Linux') {
                $this->currentDirectory = getcwd();
                $this->commandLine = 'bash -c "cd ' . $this->currentDirectory . '";';
            }

            $this->dispatchBrowserEvent('laravel-shell:directory-change', ['directory' => $this->currentDirectory]);
        } else {
            $this->dispatchBrowserEvent('laravel-shell:terminal-output', ['output' => [__('Directory does not exist.')]]);
        }
    }
}
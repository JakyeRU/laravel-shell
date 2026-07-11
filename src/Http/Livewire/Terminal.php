<?php

namespace Jakyeru\LaravelShell\Http\Livewire;

use Illuminate\Support\Str;
use Jakyeru\LaravelShell\Rules\CommandRule;
use Livewire\Attributes\Layout;
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
     * Mount the component.
     */
    #[Layout('laravel-shell::layouts.app')]
    public function mount(): void
    {
        $this->changeDirectory(base_path(), false);
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
        $command = trim($command);

        chdir($this->currentDirectory);

        if ($command === 'cd' || Str::startsWith($command, 'cd ')) {
            $target = trim(substr($command, 2));
            $this->changeDirectory($target === '' ? base_path() : $target);
            return;
        }

        $validator = validator(['command' => $command], [
            'command' => ['required', new CommandRule],
        ]);

        if ($validator->fails()) {
            $this->dispatch('laravel-shell:terminal-output', ['output' => [$validator->errors()->first()]]);
            return;
        }

        $output = [];

        exec($this->shellCommand($command) . ' 2>&1', $output);

        $output = array_map('rtrim', $output);

        $this->dispatch('laravel-shell:terminal-output', ['output' => array_values($output)]);
    }

    /**
     * Change the current directory.
     */
    public function changeDirectory(string $directory, bool $dispatch = true): void
    {
        if (! is_dir($directory)) {
            $this->dispatch('laravel-shell:terminal-output', ['output' => [__('Directory does not exist.')]]);
            return;
        }

        chdir($directory);

        $this->currentDirectory = str_replace('\\', '/', getcwd());

        if ($dispatch) {
            $this->dispatch('laravel-shell:directory-change', ['directory' => $this->currentDirectory]);
        }
    }

    /**
     * Create the shell command for the current operating system.
     **/
    protected function shellCommand(string $command): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return 'C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe -Command ' . escapeshellarg($command);
        }

        return 'bash -c ' . escapeshellarg($command);
    }
}
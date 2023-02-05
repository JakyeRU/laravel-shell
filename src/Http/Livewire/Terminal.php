<?php

namespace Jakyeru\LaravelShell\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class Terminal extends Component
{
    public string $currentDirectory;
    public string $commandLine;

    public function mount(): void
    {
        config(['livewire.layout' => 'laravel-shell::layouts.app']);
        config(['livewire.class_namespace' => 'Jakyeru\LaravelShell\Http\Livewire']);

        $this->currentDirectory = getcwd();

        if (php_uname('s') === 'Windows NT') {
            $this->currentDirectory = str_replace('\\', '/', $this->currentDirectory);
            $this->commandLine = 'powershell.exe -NoLogo -NoProfile -Command "cd ' . $this->currentDirectory . '; $host.ui.RawUI.WindowTitle = \'Laravel Shell\';"';
        } else if (php_uname('s') === 'Linux') {
            $this->commandLine = 'bash -c "cd ' . $this->currentDirectory . '; exec bash"';
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('laravel-shell::livewire.terminal');
    }

    public function runCommand($command)
    {
        chdir($this->currentDirectory);

        if (Str::startsWith($command, 'cd')) {
            $this->changeDirectory(substr($command, 3));
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

    public function changeDirectory($directory)
    {
        if (is_dir($directory)) {
            chdir($directory);
            if (php_uname('s') === 'Windows NT') {
                $this->currentDirectory = str_replace('\\', '/', getcwd());
                $this->commandLine = 'powershell.exe -NoLogo -NoProfile -Command "cd ' . $this->currentDirectory . '; $host.ui.RawUI.WindowTitle = \'Laravel Shell\';"';
            } else if (php_uname('s') === 'Linux') {
                $this->currentDirectory = getcwd();
                $this->commandLine = 'bash -c "cd ' . $this->currentDirectory . '; exec bash"';
            }

            $this->dispatchBrowserEvent('laravel-shell:directory-change', ['directory' => $this->currentDirectory]);
        } else {
            $this->dispatchBrowserEvent('laravel-shell:terminal-output', ['output' => ['Directory does not exist.']]);
        }
    }
}
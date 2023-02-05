<div>
    <div wire:ignore id="terminal"></div>
    <script>
        let terminalEnabled = false;
        let command = '';
        let directory = '{{ $currentDirectory }}';

        document.addEventListener('DOMContentLoaded', () => {
            const terminal = new window.Terminal({
                fontFamily: '"Cascadia Code", Menlo, monospace',
                theme: {
                    foreground: '#eff0eb',
                    background: '#282a36',
                    cursorAccent: '#282a36',
                    selection: '#97979b33',
                    black: '#282a36',
                    brightBlack: '#686868',
                    red: '#ff5c57',
                    brightRed: '#ff5c57',
                    green: '#5af78e',
                    brightGreen: '#5af78e',
                    yellow: '#f3f99d',
                    brightYellow: '#f3f99d',
                    blue: '#57c7ff',
                    brightBlue: '#57c7ff',
                    magenta: '#ff6ac1',
                    brightMagenta: '#ff6ac1',
                    cyan: '#9aedfe',
                    brightCyan: '#9aedfe',
                    white: '#f1f1f0',
                    brightWhite: '#eff0eb',
                },
                cursorBlink: true,
                cols: Math.floor(window.innerWidth / 9),
                rows: Math.floor(window.innerHeight / 19),
            });

            terminal.open(document.getElementById('terminal'));

            terminal.writeln('Welcome to \x1b[31;1mLaravel Shell\x1b[0m!');

            terminal.writeln('Running Laravel \x1b[93;1mv{{ Illuminate\Foundation\Application::VERSION }}\x1b[0m (PHP \x1b[93;1mv{{ PHP_VERSION }}\x1b[0m) (Shell: \x1b[34;1m{{ explode(' ', $commandLine)[0] }}\x1b[0m)\r\n');

            terminal.onData(e => {
                if (!terminalEnabled) return false;
                switch (e) {
                    case '\u0003': // Ctrl+C
                        terminal.write('^C');
                        prompt(terminal);
                        break;
                    case '\r': // Enter
                        if (command.trim().length > 0) {
                            terminalEnabled = false;
                        }
                        runCommand(terminal, command);
                        command = '';
                        break;
                    case '\u007F': // Backspace (DEL)
                        // Do not delete the prompt
                        if (terminal._core.buffer.x > directory.length + 3) {
                            terminal.write('\b \b');
                            command = command.substring(0, command.length - 1);
                        }
                        break;
                    default:
                        if (e >= String.fromCharCode(0x20) && e <= String.fromCharCode(0x7E) || e >= '\u00a0') {
                            command += e;
                            terminal.write(e);
                        }
                }
            });

            prompt(terminal);

            window.addEventListener('resize', () => {
                terminal.resize(Math.floor(window.innerWidth / 9), Math.floor(window.innerHeight / 19));
            });

            window.addEventListener('laravel-shell:terminal-output', (event) => {
                if (typeof event.detail.output === 'string') {
                    terminal.writeln(event.detail.output);
                } else if (Array.isArray(event.detail.output)) {
                    event.detail.output.forEach(line => {
                        terminal.writeln(line);
                    })
                }

                prompt(terminal);
            });

            window.addEventListener('laravel-shell:directory-change', (event) => {
                directory = event.detail.directory;
                prompt(terminal);
            });
        });

        function prompt(terminal) {
            terminal.write(`\r\n${directory} $ `);
            terminalEnabled = true;
        }

        function runCommand(terminal, text) {
            const command = text.trim().split(' ')[0];

            if (command.length > 0) {
                terminal.writeln('');

                @this.runCommand(text);
            } else {
                prompt(terminal);
            }
        }
    </script>
</div>
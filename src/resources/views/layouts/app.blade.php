<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Shell</title>

    <!-- Styles -->
    <link href="{{ route('laravel-shell.assets.serve', 'xterm.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body style="background-color: {{ config('laravel-shell.terminal.colors.background') }};">
    {{ $slot }}
    <!-- Scripts -->
    @livewireScripts
    <script src="{{ route('laravel-shell.assets.serve', 'xterm.js') }}"></script>
</body>
</html>

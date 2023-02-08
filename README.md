<p align="center">
    <a href="https://github.com/JakyeRU/Laravel-Shell" target="_blank">
        <img src="https://raw.githubusercontent.com/JakyeRU/Laravel-Shell/main/.github/Laravel-Shell-transparent.png" height=200>
    </a>
</p>

<p align="center">
    <img src="https://img.shields.io/github/v/release/jakyeru/laravel-shell?logo=github&color=blue&style=for-the-badge" alt="release">
</p>

# About Laravel Shell
> **Warning** Laravel-Shell is not a full-fledged terminal interface and its functionality is limited to running shell commands via the PHP exec function. As a result, it may not be suitable for running interactive shell processes. However, this package was designed specifically to aid administrators on shared servers that do not have SSH access, but it can be utilized by anyone. Keep this in mind when deciding if this package meets your needs.

Laravel-Shell is a package for Laravel applications that adds a terminal interface to your web application. This allows you to run shell commands directly from your browser. With "Laravel-Shell", you can access the terminal from anywhere, at any time, and execute commands on the fly.

The package integrates seamlessly into Laravel, and the terminal interface is intuitive and user-friendly. You can run a wide range of commands, including those related to database management, file management, and more.

# Installation
You can install the package via composer:

```bash
composer require jakyeru/laravel-shell
```
After installing you can navigate to `/laravel-shell` to access the terminal.
> **Warning** It is recommended that you secure your terminal with a middleware by publishing the configuration.
```bash
php artisan vendor:publish --provider="Jakyeru\LaravelShell\LaravelShellServiceProvider" --tag="config"
```

# Version Compatibility
> **Note** Laravel-Shell follows [Laravel's Support Policy](https://laravel.com/docs/9.x/releases#support-policy).

|  Laravel Version  |  Laravel-Shell Version  | PHP Version | Active Support | Security Fixes |
|:-----------------:|:-----------------------:|:-----------:|:--------------:|:--------------:|
|         9         |          1.X.X          |    >=8.0    |       ✅       |       ✅      |

# Screenshots
<p align="center">
    <img src="https://raw.githubusercontent.com/JakyeRU/Laravel-Shell/main/.github/Screenshot_2023-02-05_192731.png" height=200><br>
    <img src="https://raw.githubusercontent.com/JakyeRU/Laravel-Shell/main/.github/Screenshot_2023-02-05_193258.png" height=200>
</p>

# License
Laravel-Shell is open-sourced software licensed under the [MIT](https://github.com/JakyeRU/Laravel-Shell/blob/main/LICENSE) license.

If you encounter any other error(s), please open an issue on [GitHub](https://github.com/JakyeRU/Laravel-Shell/issues/new/choose).

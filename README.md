<div align="center">
    <h1>Laravel Menu</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/directsoft/laravel-menu"><img src="https://img.shields.io/packagist/v/directsoft/laravel-menu.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/directsoft/laravel-menu"><img src="https://img.shields.io/packagist/php-v/directsoft/laravel-menu.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/directsoft/laravel-menu"><img src="https://badge.laravel.cloud/badge/directsoft/laravel-menu?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/directsoft/laravel-menu/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/directsoft/laravel-menu/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/directsoft/laravel-menu"><img src="https://img.shields.io/packagist/dt/directsoft/laravel-menu.svg?style=flat-square" alt="Total Downloads"></a>
</p>

Laravel Menu

## Installation

You can install the package via Composer:

```bash
composer require directsoft/laravel-menu
```

You may publish all the package's resources at once:

```bash
php artisan vendor:publish --tag="menu"
```

Or, you may publish each resource individually:

### Publishing the Configuration File

```bash
php artisan vendor:publish --tag="menu-config"
```

### Publishing and Running the Migrations

```bash
php artisan vendor:publish --tag="menu-migrations"
php artisan migrate
```

### Publishing the Views

```bash
php artisan vendor:publish --tag="menu-views"
```

### Publishing the Public Assets

```bash
php artisan vendor:publish --tag="menu-assets"
```

## Usage

<!-- Add a basic usage example here. -->

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Laravel Menu! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Ivan Stoianov](https://github.com/ivan-stoianov)
- [All Contributors](../../contributors)

## License

Laravel Menu is open-source software licensed under the [MIT license](LICENSE.md).

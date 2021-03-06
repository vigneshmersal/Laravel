# composer
## Laravel Installer
> composer global require laravel/installer

## Check
// show all installed pacgages.
// -i = installed, -t = tree
> composer show
> composer show -i
> composer global show
> composer global show -i

// show specific package
> composer show nesbot/carbon

## clear
> composer clearcache

## Update laravel installer 4.X
1. `composer global require "laravel/installer:^4.0"`
    - (or) `composer global require "laravel/homestead=~7.0" --with-all-dependencies`
    - verify: `laravel --version`
2. uninstall and reinstall
    - `laravel global remove laravel/installer`
    - `laravel global require laravel/installer`
3. `composer.json`
    - { "require": { "laravel/installer": "^4.0" } }
    - `composer update`
4. upgrade new version
    - `composer global update`

Php extension issues,
> composer install --ignore-platform-reqs

## composer Commands
- `composer outdated` - It will show all packages compared to new version.
    + `composer outdated --direct`

- `composer update`

> composer require "laravelcollective/html":"^5.8.0"

## Install composer globally
Windows
- goto [`getcomposer.org`](https://getcomposer.org/doc/00-intro.md#installation-windows)
- Download Composer-Setup.exe

Linux
- goto [`getcomposer.org/download`](https://getcomposer.org/download/)
- Copy & Paste - 4 lies of PHP Code
- Check Installed correctly by: `php composer.phar`
- To add globally by: `mv composer.phar /usr/local/bin/composer`
- If added globally check by: `composer`

## Update composer Windows/Linux
> composer self-update --snapshot
go back to any version,
> composer self-update --2
> composer self-update --1

---

## Create project
> composer create-project --prefer-dist laravel/laravel blog "5.5"

create a new application with all of the authentication scaffolding compiled and installed:
> laravel new blog --auth

## Done everything for us - like composer|migration
> composer require laracasts/generators --dev
> composer require laracasts/testdummy --dev

## Laravel browser console [Debugbar](https://github.com/barryvdh/laravel-debugbar)
> composer require barryvdh/laravel-debugbar --dev

## Install tinker
> composer require laravel/tinker

## laravel test
Call By
> composer test
```json
{
    "scripts": {
        "test": [
            "vendor/bin/phpunit"
        ]
    }
}
```

## sample Json
```json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The Laravel Framework.",
    "keywords": [
        "framework",
        "laravel"
    ],
    "license": "MIT",
    "require": {
        "php": "^7.1.3",
        "cartalyst/stripe": "~2.0",
        "fideloper/proxy": "^4.0",
        "laravel/framework": "5.8.*",
        "laravel/tinker": "^1.0",
        "maddhatter/laravel-fullcalendar": "^1.3",
        "stripe/stripe-php": "^7.27",
        "yajra/laravel-datatables": "^1.5",
        "opentok/opentok": "4.4.x"
    },
    "require-dev": {
        "beyondcode/laravel-dump-server": "^1.0",
        "filp/whoops": "^2.0",
        "fzaninotto/faker": "^1.4",
        "mockery/mockery": "^1.0",
        "nunomaduro/collision": "^3.0",
        "phpunit/phpunit": "^7.5",
        "xethron/migrations-generator": "^2.0"
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "autoload": {
        "files": [
            "app/Helpers/Helper.php"
        ],
        "psr-4": {
            "App\\": "app/"
        },
        "classmap": [
            "database/seeds",
            "database/factories"
        ]
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true,
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ],
    }
}
```

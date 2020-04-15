# composer.json

## Create project
> composer create-project --prefer-dist laravel/laravel blog

## Install Passport
> composer require laravel/passport
> php artisan migrate
> php artisan passport:install


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

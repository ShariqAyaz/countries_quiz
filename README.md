### Configuration
- PHP **8.4.1** (cli) (built: Nov 20 2024 09:48:35) (NTS)
- Composer version **2.7.7** 2024-06-10 22:11:12
- PHP version **8.4.1** (/opt/homebrew/Cellar/php/8.4.1_1/bin/php)
- Laravel Framework **11.35.1**

## Laravel Quiz
- Laravel Based Quiz Application allow user to guess correct Capital city of the asked country.

## User Requirments
- A User interface that allows users to interact with the quiz. √
- Each time a random country display with 3 options including one correct. √
- User allow to select at least one. √
- Upon submit, user can see feedback if answer correct, or display a correct capital if guess was wrong. √
- Using button user can to continue new quiz. √
- Application behave like recursive until user exit the application. √

## Technical Requirements
- Backend on Laravel
### Frontend:
-  Blade       √ (branch: main) (Approx. 4hrs)
-  Livewire    Next Iteration (branch: livewire)
-  React       √ (branch: react-stateful) - Stateful
-  React       Partially done (branch: react) - Stateless
-  Vue         Next Iteration (branch: vuejs)

### Cache:
- CACHE_STORE=database
- CACHE_PREFIX=quiz_

#### Form Request Validation
```php artisan make:request AnswerValidationRequest```

```
    public function rules(): array
    {
        return [
            'country' => 'required|string|min:1',
            'capital' => 'required|string|min:1',
        ];
    }

    public function message(): array
    {
        return [
            'country.required' => 'Country Require',
            'country.string' => 'Country should be String',
            'capital.required' => 'Capital Require',
            'capital.string' => 'Capital should be String',
        ];
    }
    
```


> i.e., https://laravel.com/docs/11.x/validation#creating-form-requests

```
> composer create-project laravel/laravel laravel_quiz
> php artisan make:controller CountriesQuizController
> php artisan make:request AnswerValidationRequest
> View:

> mkdir -p resources/views/layout/ && touch resources/views/layout/header.blade.php && touch resources/views/layout/footer.blade.php && touch resources/views/layout/result.blade.php
resources/views
├── index.blade.php
├── layout
│   ├── footer.blade.php
│   └── header.blade.php
└── result.blade.php
```

# create your own API endpoint within your application to call the external endpoint securely.
- Info: In Laravel 11 the api.php does not include require to install by ```php artisan install:api``` and it resolve santum dependencies as well.

- ![image](https://github.com/user-attachments/assets/acb13314-231e-4335-931d-096fbffefa45)


## Below all dependencies can be found
```
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.31",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.9"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pail": "^1.1",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.26",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.1",
        "phpunit/phpunit": "^11.0.1"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
            "@php artisan migrate --graceful --ansi"
        ],
        "dev": [
            "Composer\\Config::disableProcessTimeout",
            "npx concurrently -c \"#93c5fd,#c4b5fd,#fb7185,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"php artisan pail --timeout=0\" \"npm run dev\" --names=server,queue,logs,vite"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}

```

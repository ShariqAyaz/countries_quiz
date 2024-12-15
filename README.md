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
-  React       Next Iteration (branch: react)
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
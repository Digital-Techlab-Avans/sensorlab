<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validateAvansEmail();
    }

    public function validateAvansEmail()
    {
        Validator::extend('avans_email', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^.+\..+@(student\.)?avans\.nl$/', $value) != false;
        });

        Validator::replacer('avans_email', function ($message, $attribute, $rule, $parameters) {
            return 'Je moet een Avans e-mailadres gebruiken.';
        });
    }
}

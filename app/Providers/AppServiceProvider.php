<?php

namespace App\Providers;

use Code\Validator\Cpf;
use Code\Validator\Cnpj;
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
        //Traduz faker para pt-BR
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Evita erros com as versões mais antigas do mysql
        \Schema::defaultStringLength(191);

        //Cria um validador para CPF e CNPJ
        \Validator::extend('document_number', function ($attribute, $value, $parameters, $validator) {
            $documentValidator = $parameters[0] == 'cpf' ? new Cpf() : new Cnpj();
            return $documentValidator->isValid($value);
        });
    }
}

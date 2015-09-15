<?php

namespace LaravelPrototype\Interfaces;

use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider {

    public function register() {
        $app = $this->app;

        /* Manual classes for first building objects */
//        $app->bind('LaravelPrototype\Interfaces\ProductInterface', 'LaravelPrototype\ManualClasses\Book');

        /* DB classes after finishing DB interaction */
//        $app->bind('LaravelPrototype\Interfaces\ProductInterface', 'LaravelPrototype\DBClasses\Book');
    }
}
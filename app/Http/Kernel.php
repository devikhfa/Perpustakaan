<?php

namespace App\Http;

class Kernel extends \Illuminate\Foundation\Http\Kernel
{
    protected $routeMiddleware = [
        'auth.session' => \App\Http\Middleware\AuthMiddleware::class
    ];
}
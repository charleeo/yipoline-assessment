<?php

use App\Http\Controllers\UserController;

$routes =  [
    '/' => [UserController::class,  'index'],
    '/success' => [UserController::class, 'success'],
    '/success/{id}' => [UserController::class, 'success'],
];
<?php

namespace App\Controllers;

use App\Views\AuthView;

class AuthController extends Controller
{
    public function data()
    {
        return ['view' => new AuthView()];
    }
}
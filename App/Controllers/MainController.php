<?php

namespace App\Controllers;

use App\Views\TodosView;

class MainController extends Controller
{
    public function data($params)
    {
        return ['view' => new TodosView()];
    }
}
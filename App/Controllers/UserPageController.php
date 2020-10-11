<?php

namespace App\Controllers;

use App\Views\UserView;

class UserPageController extends Controller
{
    public function __construct($params)
    {
        parent::__construct($params);
    }

    public function data()
    {
        $this->getAdmin();
        return ['view' => UserView::class, 'responce' => $this->getResponce()];
    }
}
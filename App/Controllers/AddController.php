<?php

namespace App\Controllers;

use App\Models\TodosModel;

class AddController extends Controller
{
    public function addAsGet($params)
    {
        if ($params) {
            $newTodo = new TodosModel($params);
            TodosModel::add($newTodo);
        }
        return ['redirect' => '/'];
    }

    public function add($params)
    {
        if ($params) {
            $params = $this->prepareParams($params);
            $newTodo = new TodosModel($params);
            TodosModel::add($newTodo);
        }
        return ['redirect' => '/'];
    }
}
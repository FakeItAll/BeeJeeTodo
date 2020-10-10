<?php

namespace App\Controllers;

use App\Models\TodosModel;
use App\Views\TodosView;

class AddController extends Controller
{
    public function addGet($params)
    {
        if ($params) {
            $newTodo = new TodosModel(
                $params['name'] ?? '',
                $params['email'] ?? '',
                $params['text'] ?? ''
            );
            TodosModel::add($newTodo, count(TodosModel::all()) + 1);
            return ['view' => new TodosView()];
        }
    }

    public function add($params)
    {
        if ($params) {
            $params = $this->prepareParams($params);
            $newTodo = new TodosModel(
                $params['name'] ?? '',
                $params['email'] ?? '',
                $params['text'] ?? ''
            );
            TodosModel::add($newTodo, count(TodosModel::all()) + 1);
        }
        return ['redirect' => '/'];
    }
}
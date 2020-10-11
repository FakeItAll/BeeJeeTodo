<?php

namespace App\Controllers;

use App\Models\TodosModel;

class AddController extends Controller
{
    public function add()
    {
        $this->paramsTo([
            'name' => 'string',
            'email' => 'string',
            'text' => 'string',
        ]);
        if ($this->params['name'] && $this->params['email'] && $this->params['text']) {
            TodosModel::add(new TodosModel($this->params));
        }
        else {
            $this->setResponce('emptyData');
        }
        return ['redirect' => '/'];
    }
}
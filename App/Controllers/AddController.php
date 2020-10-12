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
            TodosModel::add(new TodosModel([
                'name' => $this->params['name'],
                'email' => $this->params['email'],
                'text' => $this->params['text'],
                'edited' => 0,
                'completed' => 0,
            ]));
            $this->setResponce('success', 'successAdd');
        }
        else {
            $this->setResponce('error', 'emptyData');
        }
        return ['redirect' => '/'];
    }
}
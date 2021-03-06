<?php


namespace App\Controllers;


use App\Models\TodosModel;

class ChangeController extends Controller
{
    public function __construct($params)
    {
        parent::__construct($params);
    }

    public function change()
    {
        if ($user = $this->getAdmin()) {
            $this->paramsTo([
                'change' => 'bool',
                'complete' => 'bool',
                'id' => 'int',
            ]);
            if ($this->params['change']) {
                $this->paramsTo([
                    'name' => 'string',
                    'email' => 'string',
                    'text' => 'string',
                ]);
                if ($this->params['name'] && $this->params['email'] && $this->params['text']) {
                    if ($curTodo = TodosModel::getById($this->params['id'])) {
                        $editFlag = $curTodo->text !== $this->params['text'];
                        if ($editFlag) {
                            $curTodo->text = $this->params['text'];
                            $curTodo->edited = 1;
                            TodosModel::edit($curTodo, 'id', $curTodo->id);
                            $this->setResponce('success', 'successEdit');
                        }
                    }
                }
                else {
                    $this->setResponce('error', 'emptyData');
                }
            }
            elseif ($this->params['complete']) {
                if ($curTodo = TodosModel::getById($this->params['id'])) {
                    $curTodo->completed = $curTodo->completed == 0 ? 1 : 0;
                    TodosModel::edit($curTodo, 'id', $curTodo->id);
                    $this->setResponce('success', 'successComplete');
                }
            }
        }
        else {
            $this->setResponce('error', 'accessDenied');
        }
        return ['redirect' => '/'];
    }
}

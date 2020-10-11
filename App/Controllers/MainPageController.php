<?php

namespace App\Controllers;

use App\Models\TodosModel;
use App\Views\TodosView;

class MainPageController extends Controller
{
    public function data()
    {
        $this->paramsTo([
            'page' => 'int',
            'order' => 'string',
            'desc' => 'bool',
        ]);

        $this->params['page'] -= 1;
        if ($this->params['page'] && $this->params['page'] > 0) {
            TodosModel::$page = $this->params['page'];
        }
        if (
            $this->params['order']
            && in_array($this->params['order'], TodosModel::$sortableFields)
        ) {
            TodosModel::$sort = [
                $this->params['order'] => $this->params['desc']
            ];
        }
        return ['view' => TodosView::class, 'responce' => $this->getResponce()];
    }
}
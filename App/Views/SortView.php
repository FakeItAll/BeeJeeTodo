<?php


namespace App\Views;


use App\Models\TodosModel;

class SortView extends View
{
    protected $templatesSubDir = 'todo/sort';

    protected $fields = [
        'name' => 'Название',
        'email' => 'Email',
        'completed' => 'Статус',
    ];

    protected function nextType($type)
    {
        switch ($type) {
            case '':
                return 'asc';
            case 'asc':
                return 'desc';
            case 'desc':
                return '';
        }
        return '';
    }

    protected function prepareSort($sort)
    {
        $this->params = [];
        foreach ($this->fields as $name => $field) {
            $type = '';
            if (isset($sort[$name])) {
                $type = $sort[$name] ? 'desc': 'asc';
            }
            $nextType = $this->nextType($type);
            $urlParams = [];
            if ($nextType != '') {
                $urlParams = [
                    'order' => $name,
                    'desc' => $nextType == 'desc',
                ];
            }
            $this->params[] = [
                'field' => $field,
                'url' => $this->getUrl('/', $urlParams),
                'type' => $type == '' ? 'default' : $type,
            ];
        }
    }

    public function execute()
    {
        $this->prepareSort(TodosModel::$sort);
        $contents = [];
        foreach ($this->params as $param) {
            $contents[] = $this->getReplaceTemplate($param['type'], $param) . ' ';
        }
        return implode( ' ', $contents);
    }
}
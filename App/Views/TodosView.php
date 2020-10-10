<?php


namespace App\Views;

use App\Models\TodosModel;

class TodosView extends View
{
    private function prepareTodo($params)
    {
        return [
            'name' => $params['name'] ?? '',
            'email' => $params['email'] ?? '',
            'text' => $params['text'] ?? ''
        ];
    }

    public function __construct()
    {
        $todos = TodosModel::all();
        $todosContent = '';
        foreach ($todos as $todo) {
            $todoParams = $this->prepareTodo($todo->toArr());
            $todosContent .= $this->getReplaceTemplate('todo', $this->prepareTodo($todoParams));
        }

        $todopanelContent = $this->getReplaceTemplate('todopanel', ['todos' => $todosContent]);

        $layoutParams = [
            'title' => 'Todos',
            'desciption' => 'You can make some todo',
            'content' => $todopanelContent
        ];
        $this->content = $this->getReplaceTemplate('layout', $this->prepareLayout($layoutParams));
    }
}
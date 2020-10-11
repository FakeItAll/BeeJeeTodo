<?php


namespace App\Views;

use App\Models\TodosModel;

class TodosView extends View
{
    private function prepareTodo($params)
    {
        return [
            'id' => $params['id'] ?? '',
            'name' => $params['name'] ?? '',
            'email' => $params['email'] ?? '',
            'text' => $params['text'] ?? ''
        ];
    }

    public function execute()
    {
        $todos = TodosModel::mainView();
        $todosContent = '';
        foreach ($todos as $todo) {
            $todoParams = $this->prepareTodo($todo->toArr());
            $todosContent .= $this->getReplaceTemplate('todo', $this->prepareTodo($todoParams));
        }

        $todopanelContent = $this->getReplaceTemplate('todopanel', ['todos' => $todosContent]);

        $layoutParams = array_merge([
            'title' => 'Todos',
            'desciption' => 'You can make some todo',
            'content' => $todopanelContent,
        ], $this->params ?? []);
        $this->content = (new LayoutView($layoutParams))->execute();
        return $this->content;
    }
}
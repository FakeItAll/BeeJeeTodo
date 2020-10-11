<?php


namespace App\Views;

use App\Models\TodosModel;
use App\Models\UsersModel;

class TodosView extends View
{
    protected $templatesSubDir = 'todo';

    protected function prepareTodo($params)
    {
        $result = [
            'id' => $params['id'] ?? '',
            'name' => $params['name'] ?? '',
            'email' => $params['email'] ?? '',
            'text' => $params['text'] ?? '',
            'edited' => $params['edited'] ?? false,
            'completed' => $params['completed'] ?? false,
            'change_url' => $this->getUrl('/change'),
        ];
        return $result;
    }

    protected function getItemFooter($params)
    {
        $components = [
            'edit' => '',
            'complete' => '',
            'edited' => $params['edited'] ?
                $this->getTemplate('item-footer/edited') : '',
            'completed' => $params['completed'] ?
                $this->getTemplate('item-footer/completed') : '',
        ];
        if ($params['admin']) {
            $components['edit'] = $this->getTemplate('item-footer/edit');
            $components['complete'] = $params['completed'] ?
                $this->getTemplate('item-footer/cross') :
                $this->getTemplate('item-footer/check');
        }
        return $this->getReplaceTemplate('item-footer/container', $components);
    }

    public function execute()
    {
        $todos = TodosModel::mainView();
        $allCount = TodosModel::allCount();
        $itemsCount = TodosModel::$itemsCount;
        $user = UsersModel::getCurrentUser();
        $todosContent = '';
        foreach ($todos as $todo) {
            $todo = $todo->toArr();
            $params = $this->prepareTodo($todo);

            $params['admin'] = !empty($user);

            $params['footer'] = '';
            if ($user || $params['edited'] || $params['completed']) {
                $params['footer'] = $this->getItemFooter($params);
            }

            $todosContent .= $this->getReplaceTemplate(
                $user ? 'adminitem' : 'item',
                $params
            );
        }
        $containerParams = [
            'todos' => $todosContent,
            'add_url' => $this->getUrl('/add'),
        ];
        $containerParams['sort'] = (new SortView())->execute();
        $containerParams['pagination'] = $allCount > $itemsCount ? (new PaginationView())->execute() : '';

        $containerContent = $this->getReplaceTemplate('container', $containerParams);

        $layoutParams = array_merge([
            'page' => 'main',
            'title' => 'Todos',
            'desciption' => 'You can make some todo',
            'content' => $containerContent,
        ], $this->params ?? []);
        $this->content = (new LayoutView($layoutParams))->execute();
        return $this->content;
    }
}
<?php


namespace App\Views;


use App\Models\UsersModel;

class LayoutView extends View
{
    protected $templatesSubDir = 'main';

    protected $messages = [
        '' => 'Неизвестная ошибка!',
        'emptyData' => 'Заполните все поля!',
        'authFailed' => 'Неправильный логин и/или пароль!',
        'accessDenied' => 'Доступ запрещен!',
        'successAdd' => 'Задача добавлена!',
        'successEdit' => 'Задача изменена!',
        'successComplete' => 'Статус изменен!',
        'successAuth' => 'Вы успешно авторизовались!',
    ];

    protected function prepareLayout()
    {
        $result = [
            'title' => $this->params['title'] ?? '',
            'desciption' => $this->params['description'] ?? '',
            'content' => $this->params['content'] ?? '',
            'message' => $this->params['message'],
            'menu' => $this->params['menu'],
        ];
        return $result;
    }

    protected function prepareMenu($login)
    {
        $result = [];
        $result[] = [
            'name' => 'Главная',
            'url' => $this->getUrl('/'),
            'active' => $this->params['page'] == 'main',
        ];
        $result[] = [
            'name' => $login ? "Профиль ($login)" : 'Авторизация',
            'url' => $this->getUrl('/user'),
            'active' => $this->params['page'] == 'user',
        ];
        return $result;
    }

    protected function prepareMessage($responceText)
    {
        return [
            'message' => $this->messages[$responceText]
        ];
    }

    public function execute()
    {
        $login = '';
        if ($user = UsersModel::getCurrentUser()) {
            $login = $user->login;
        }
        $menu = '';
        foreach ($this->prepareMenu($login) as $menuItem) {
            $menu .= $this->getReplaceTemplate(
                $menuItem['active'] ? 'menu-active' : 'menu-item',
                $menuItem
            );
        }
        $this->params['menu'] = $menu;
        $this->params['message'] = '';
        if (!empty($this->params['responce'])) {
            $this->params['message'] = $this->getReplaceTemplate(
                ($this->params['responce']['type'] ?? '') == 'success' ? 'success' : 'error',
                $this->prepareMessage($this->params['responce']['message'] ?? '')
            );
        }
        $this->content = $this->getReplaceTemplate(
            'layout', $this->prepareLayout()
        );
        return $this->content;
    }
}
<?php


namespace App\Views;


use App\Models\UsersModel;

class UserView extends View
{
    protected $templatesSubDir = 'user';

    public function execute()
    {
        if ($user = UsersModel::getCurrentUser()) {
            $userPanelParams = ['login' => $user->login, 'logout_url' => '/user/logout'];
            $content = $this->getReplaceTemplate('panel', $userPanelParams);
            $title = 'Профиль';
            $description = 'Страница профиля пользователя';
        }
        else {
            $authFormParams = ['auth_url' => $this->getUrl('/user/auth')];
            $content = $this->getReplaceTemplate('authform', $authFormParams);
            $title = 'Авторизация';
            $description = 'Страница авторизации';
        }
        $layoutParams = array_merge([
            'page' => 'user',
            'title' => $title,
            'desciption' => $description,
            'content' => $content,
        ], $this->params ?? []);
        $this->content = (new LayoutView($layoutParams))->execute();
        return $this->content;
    }
}
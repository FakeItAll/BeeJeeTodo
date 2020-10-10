<?php


namespace App\Views;


use App\Models\UsersModel;

class AuthView extends View
{
    public function __construct()
    {
        $authFormContent = $this->getTemplate('authform');

        $layoutParams = [
            'title' => 'Auth',
            'desciption' => 'Authentication page',
            'content' => $authFormContent
        ];
        $this->content = $this->getReplaceTemplate('layout', $this->prepareLayout($layoutParams));
    }
}
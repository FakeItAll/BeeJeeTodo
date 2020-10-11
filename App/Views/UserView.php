<?php


namespace App\Views;


use App\Models\UsersModel;

class UserView extends View
{
    public function execute()
    {
        if ($user = UsersModel::getCurrentUser()) {
            $userPanelContent = $this->getTemplate('userpanel');
            $layoutParams = [
                'title' => 'UserPanel',
                'desciption' => 'UserPanel page',
                'content' => $userPanelContent
            ];
        }
        else {
            $authFormContent = $this->getTemplate('authform');
            $layoutParams = array_merge([
                'title' => 'Auth',
                'desciption' => 'Authentication page',
                'content' => $authFormContent
            ], $this->params ?? []);
        }
        $this->content = (new LayoutView($layoutParams))->execute();
        return $this->content;
    }
}
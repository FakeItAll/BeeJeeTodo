<?php


namespace App\Controllers;

use App\Models\UsersModel;

class AuthController extends Controller
{
    public function auth()
    {
        if (!$this->getAdminId()) {
            $this->paramsTo([
                'login' => 'string',
                'password' => 'string',
            ]);
            if ($this->params['login'] && $this->params['password']) {
                $user = UsersModel::getByLogin($this->params['login']);
                if ($user->password === $this->params['password']) {
                    UsersModel::setCurrentUser($user);
                    $this->saveAdmin($user);
                    return ['redirect' => '/user'];
                }
            }
            $this->setResponce('authFailed');
        }
        return ['redirect' => '/user'];
    }

    public function logout()
    {
        $this->deleteAdmin();
        return ['redirect' => '/user'];
    }
}
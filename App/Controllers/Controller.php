<?php

namespace App\Controllers;

use App\Models\UsersModel;

abstract class Controller
{
    protected $params;

    public function __construct($params)
    {
        session_start();
        foreach ($params as $k => $v) {
            $params[$k] = addslashes(htmlspecialchars($v));
        }
        $this->params = $params;
    }

    public function paramsTo($paramTypes)
    {
        foreach ($paramTypes as $param => $type) {
            switch ($type) {
                case 'int':
                    $this->params[$param] = (int)($this->params[$param] ?? 0);
                    break;
                case 'bool':
                    $this->params[$param] = (bool)($this->params[$param] ?? false);
                    break;
                default:
                    $this->params[$param] = (string)($this->params[$param] ?? '');
            }
        }
    }

    public function getAdminId()
    {
        return !empty($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function getAdmin()
    {
        $userId = $this->getAdminId();
        if (!$userId) {
            return false;
        }
        return UsersModel::rememberCurrentUser($userId);
    }

    public function saveAdmin($user)
    {
        $_SESSION['id'] = $user->id;
    }

    public function deleteAdmin()
    {
        if ($this->getAdminId()) {
            unset($_SESSION['id']);
        }
    }

    public function setResponce($message)
    {
        $_SESSION['responce'] = $message;
    }

    public function getResponce()
    {
        if (!empty($_SESSION['responce'])) {
            $message = $_SESSION['responce'];
            unset($_SESSION['responce']);
            return $message;
        }
        return null;
    }
}
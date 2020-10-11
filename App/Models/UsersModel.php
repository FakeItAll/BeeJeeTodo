<?php

namespace App\Models;

class UsersModel extends Model
{
    protected static $currentUser = null;
    public static $table = 'users';

    public static function getByLogin($login)
    {
        return parent::get('login', $login);
    }

    public static function isUser()
    {
        return !empty(static::$currentUser);
    }

    public static function setCurrentUser($user)
    {
        static::$currentUser = $user;
        return $user;
    }

    public static function getCurrentUser()
    {
        return static::$currentUser;
    }

    public static function rememberCurrentUser($id)
    {
        if (static::isUser()) {
            return static::getCurrentUser();
        }
        return static::setCurrentUser(static::getById($id));
    }
}
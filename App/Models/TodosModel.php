<?php

namespace App\Models;

class TodosModel extends Model
{
    public static $table = 'todos';
    public static $itemsCount = 3;
    public static $sortableFields = ['name', 'email', 'completed'];

    public static $page = 0;
    public static $sort = null;
    public static $allCount = -1;

    public $name;
    public $email;
    public $text;
    public $completed = 0;
    public $edited = 0;

    public static function mainView()
    {
        $result = parent::paginate(self::$page, self::$itemsCount, self::$sort);
        return $result;
    }

    public static function allCount()
    {
        if (self::$allCount == -1) {
            self::$allCount = parent::count();
        }
        return self::$allCount;
    }
}
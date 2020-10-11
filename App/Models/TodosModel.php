<?php

namespace App\Models;

class TodosModel extends Model
{
    public static $table = 'todos';
    public static $page = 0;
    public static $itemsCount = 3;
    public static $sort = null;
    public static $sortableFields = ['name', 'email', 'text'];

    public $name;
    public $email;
    public $text;
    public $completed = 0;
    public $edited = 0;

    public static function mainView()
    {
        return parent::paginate(self::$page, self::$itemsCount, self::$sort);
    }
}
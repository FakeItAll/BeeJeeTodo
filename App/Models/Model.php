<?php

namespace App\Models;

abstract class Model
{
    protected static $collection = [];
    protected static $idCounter = 1;

    public $id;

    public static function init()
    {
        self::$collection = [];
    }

    public static function all()
    {
        return self::$collection;
    }

    public static function arr()
    {
        $arrCollection = [];
        foreach (self::$collection as $k => $v) {
            $arrCollection[$k] = (array)$v;
        }
        return $arrCollection;
    }

    public static function get($id)
    {
        return !empty(self::$collection[$id]) ? self::$collection[$id] : null;
    }

    public static function add(Model $obj, $id)
    {
        $obj->id = $id;
        self::$collection = array_merge(self::$collection, [$obj->id => $obj]);
        return $obj->id;
    }

    public static function edit(Model $obj, $id)
    {
        if (empty(self::$collection[$id])) {
            return false;
        }
        self::$collection[$id] = $obj;
        return true;
    }
}
<?php

namespace App\Models;

use App\DB;

abstract class Model
{
    public static $table = '';

    public static function all($sort = null)
    {
        return DB::instance(static::class)->all($sort);
    }

    public static function paginate($from, $count, $sort = null)
    {
        return DB::instance(static::class)->paginate($from, $count, $sort);
    }

    public static function get($column, $value)
    {
        return DB::instance(static::class)->firstBy($column, $value);
    }

    public static function getById($value)
    {
        return DB::instance(static::class)->firstBy('id', $value);
    }

    public static function add(Model $object)
    {
        return DB::instance(static::class)->add($object);
    }

    public static function edit(Model $object, $column, $value)
    {
        return DB::instance(static::class)->edit($object, $column, $value);
    }

    public function __construct($array = null)
    {
        if ($array) {
            foreach ($array as $field => $value) {
                $this->$field = $value;
            }
        }
    }

    public function toArr()
    {
        return (array)$this;
    }
}
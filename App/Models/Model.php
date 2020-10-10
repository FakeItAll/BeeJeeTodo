<?php

namespace App\Models;

use App\DB;

abstract class Model
{
    public static $table = '';

    public function toArr()
    {
        return (array)$this;
    }

    public static function all()
    {
        return DB::instance(static::class)->all();
    }

    public static function get($column, $value)
    {
        return DB::instance(static::class)->firstBy($column, $value);
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
}
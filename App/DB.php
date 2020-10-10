<?php

namespace App;

use mysqli;

class DB extends mysqli
{
    protected static $instance = null;
    protected static $model = '';
    protected static $table = '';

    public static $host = 'localhost';
    public static $username = 'beejee';
    public static $passwd = '1234';
    public static $dbname = 'beejeetodo';

    protected function __construct($host = null, $username = null, $passwd = null, $dbname = null)
    {
        parent::__construct($host, $username, $passwd, $dbname, null, null);
    }

    public static function instance($model)
    {
        if (!self::$instance) {
            self::$instance = new self(self::$host, self::$username, self::$passwd, self::$dbname);
        }
        self::$model = $model;
        self::$table = $model::$table;
        return self::$instance;
    }

    public function all()
    {
        $result = $this->query('SELECT * FROM `' . self::$table . "`");
        $collect = [];
        while ($object = $result->fetch_object(self::$model)) {
            $collect[] = $object;
        }
        return $collect;
    }

    public function paginate($from, $count)
    {
        $result = $this->query('SELECT * FROM `' . self::$table . "` LIMIT $from, $count");
        $collect = [];
        while ($object = $result->fetch_object(self::$model)) {
            $collect[] = $object;
        }
        return $collect;
    }

    public function firstBy($column, $value)
    {
        return
            $this
                ->query('SELECT * FROM `' . self::$table . "`WHERE `$column`=$value")
                ->fetch_object(self::$model);
    }

    public function add($object)
    {
        $columns = [];
        $values = [];
        foreach ($object->toArr() as $column => $value) {
            $columns[] = "`$column`";
            $values[] = "'" . $value . "'";
        }
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);
        return $this
            ->query('INSERT INTO `' . self::$table . "` ($columns) VALUES ($values)");
    }

    public function edit($object, $column, $value)
    {
        $pairs = [];
        foreach ($object->toArr() as $column => $value) {
            $pairs[] = "`$column` = '$value'";
        }
        $pairs = implode(', ', $pairs);
        return $this
            ->query('UPDATE `' . self::$table . "` SET $pairs WHERE `$column` = $value");
    }
}
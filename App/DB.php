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

    protected function selectQuery()
    {
        return 'SELECT * FROM `' . static::$table . '`';
    }

    protected function whereQuery($column, $value)
    {
        $value = $this->real_escape_string($value);
        return "WHERE `$column`='$value'";
    }

    protected function sortQuery($sort)
    {
        $result = '';
        if ($sort) {
            $orders = [];
            foreach ($sort as $orderBy => $desc) {
                $desc = $desc ? ' DESC' : '';
                $orders[] = '`' . $orderBy . '`' . $desc;
            }
            $orders = implode(', ', $orders);
            $result = "ORDER BY $orders";
        }
        return $result;
    }

    protected function limitQuery($page, $count)
    {
        $from = $page * $count;
        return "LIMIT $from, $count";
    }

    public static function instance($model)
    {
        if (!static::$instance) {
            static::$instance = new static(static::$host, static::$username, static::$passwd, static::$dbname);
        }
        static::$model = $model;
        static::$table = $model::$table;
        return static::$instance;
    }

    public function count()
    {
        $query = 'SELECT COUNT(*) as count FROM `' . static::$table . '`';
        return (int)$this->query($query)->fetch_assoc()['count'];
    }

    public function all($sort = null)
    {
        $query = implode(' ', [$this->selectQuery(), $this->sortQuery($sort)]);
        $result = $this->query($query);
        $collect = [];
        while ($object = $result->fetch_object(static::$model)) {
            $collect[] = $object;
        }
        return $collect;
    }

    public function paginate($page, $count, $sort = null)
    {
        if ($sort) {
            $query = implode(' ', [
                $this->selectQuery(),
                $this->sortQuery($sort),
                $this->limitQuery($page, $count)
            ]);
        }
        else {
            $query = implode(' ', [
                $this->selectQuery(),
                $this->limitQuery($page, $count)
            ]);
        }
        $result = $this->query($query);
        $collect = [];
        while ($object = $result->fetch_object(static::$model)) {
            $collect[] = $object;
        }
        return $collect;
    }

    public function firstBy($column, $value)
    {
        $query = implode(' ', [$this->selectQuery(), $this->whereQuery($column, $value)]);
        return
            $this
                ->query($query)
                ->fetch_object(static::$model);
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
            ->query('INSERT INTO `' . static::$table . "` ($columns) VALUES ($values)");
    }

    public function edit($object, $column, $value)
    {
        $pairs = [];
        foreach ($object->toArr() as $column => $value) {
            $pairs[] = "`$column` = '$value'";
        }
        $pairs = implode(', ', $pairs);
        return $this
            ->query('UPDATE `' . static::$table . "` SET $pairs WHERE `$column` = $value");
    }
}
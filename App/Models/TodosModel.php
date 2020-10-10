<?php

namespace App\Models;

class TodosModel extends Model
{
    public static $table = 'todos';

    public $name;
    public $email;
    public $text;
    public $completed = 0;
    public $edited = 0;

}
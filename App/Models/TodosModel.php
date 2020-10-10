<?php

namespace App\Models;

class TodosModel extends Model
{
    public $name;
    public $email;
    public $text;

    public function __construct($name, $email, $text)
    {
        $this->name = $name;
        $this->email = $email;
        $this->text = $text;
    }

}
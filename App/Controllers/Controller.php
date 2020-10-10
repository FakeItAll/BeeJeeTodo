<?php

namespace App\Controllers;

abstract class Controller
{
    protected function prepareParams($params)
    {
        foreach ($params as $k => $v) {
            $params[$k] = addslashes(htmlspecialchars($v));
        }
        return $params;
    }
}
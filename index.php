<?php

require_once 'Config.php';
require_once 'Autoloader.php';

function env($key, $default = null)
{
    return Config::get($key, $default);
}

function dd($arr)
{
    var_dump($arr);
    die();
}

function main()
{
    Config::init('.env', '.env.example');
    Autoloader::register();
    App\Router::execute();
}

main();

<?php

require_once 'Autoloader.php';

function dd($arr)
{
    die(var_dump($arr));
}

function main()
{
    Autoloader::register();
    App\Router::execute();
}

main();

<?php

require_once 'Autoloader.php';

function dd($arr)
{
    die(print_r($arr));
}

function main()
{
    Autoloader::register();
    App\Router::execute();
}

main();

<?php

require_once 'Autoloader.php';

function main()
{
    Autoloader::register();
    App\Router::execute();
}

main();

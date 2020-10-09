<?php

class Router
{
    private static $base_url = '/';

    private static $routes = [
        '/' => [
            'class' => 'MainController',
            'get' => true,
        ],
        '/add' => [
            'class' => 'AddController',
            'post' => true,
        ],
        '/auth' => [
            'class' => 'AuthController',
            'get' => true,
            'post' => true,
        ],
    ];

    public static function execute()
    {
         $uri = substr($_SERVER['REQUEST_URI'], strlen(self::$base_url));
         if (!empty(self::$routes[$uri])) {
             $class = self::$routes[$uri]['class'];
             if (!empty($_POST) && !empty(self::$routes[$uri]['post'])) {
                 $method = 'post';
                 $params = $_POST;
                 (new $class)->$method($params);
             }
             elseif (!empty(self::$routes[$uri]['get'])) {
                 $method = 'get';
                 $params = $_GET;
                 (new $class)->$method($params);
             }
             else {
                 $notFoundError = $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
                 header($notFoundError);
             }
         }

    }

}
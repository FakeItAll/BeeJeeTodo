<?php

namespace App;

class Router
{
    private static $baseUrl = '/';
    private static $controllersNamespace = 'App\\Controllers\\';

    private static $routes = [
        '/' => [
            'class' => 'MainPageController',
            'get' => 'data',
        ],
        '/user' => [
            'class' => 'UserPageController',
            'get' => 'data'
        ],
        '/add' => [
            'class' => 'AddController',
            'post' => 'add',
        ],
        '/change' => [
            'class' => 'ChangeController',
            'post' => 'change',
        ],
        '/user/auth' => [
            'class' => 'AuthController',
            'post' => 'auth',
        ],
        '/user/logout' => [
            'class' => 'AuthController',
            'get' => 'logout',
        ],
    ];

    public static function abort404()
    {
        $notFoundError = $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        header($notFoundError);
    }

    public static function redirect($path)
    {
        $redirectHeader = 'Location: ' . substr(self::$baseUrl, 0,  - 1) . $path;
        header($redirectHeader);
        die();
    }

    public static function path()
    {
        return parse_url(substr($_SERVER['REQUEST_URI'], strlen(self::$baseUrl) - 1))['path'];
    }

    public static function execute()
    {
         $path = self::path();
         if (!empty(self::$routes[$path]) && !empty(self::$routes[$path]['class'])) {
             $classname = self::$controllersNamespace . self::$routes[$path]['class'];
             $type = strtolower($_SERVER['REQUEST_METHOD']);
             $params = $_REQUEST;
             if (!empty(self::$routes[$path][$type])
                 && class_exists($classname)
                 && method_exists($controller = new $classname($params), self::$routes[$path][$type])
             ) {
                 $method = self::$routes[$path][$type];
                 if ($result = $controller->$method()) {
                     if (!empty($result['404'])) {
                         self::abort404();
                     }
                     if (!empty($result['redirect'])) {
                         self::redirect($result['redirect']);
                     }
                     if (
                         !empty($result['view'])
                         && is_a($result['view'], 'App\\Views\\View', true)
                     ) {
                         $responce = $result['responce'] ?
                             ['responce' => $result['responce']] : [];
                         $view = new $result['view']($responce);
                         $view::setBaseUrl(self::$baseUrl);
                         $view->execute();
                         $view->show();
                     }
                 }
             }
             else {
                 self::abort404();
             }
         }
         else {
             self::abort404();
         }

    }

}
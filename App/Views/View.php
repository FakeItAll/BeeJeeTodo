<?php

namespace App\Views;

abstract class View
{
    protected static $baseUrl = '/';
    private $templatesDir = 'templates/';
    protected $params = [];
    protected $content = '';

    private function loadTemplate($template)
    {
        return file_get_contents($this->templatesDir . $template . '.html');
    }

    private function replaceTemplate($templateContent, $params)
    {
        $search = array_map(function ($val) {
            return "%$val%";
        }, array_keys($params));
        $replace = array_values($params);
        return str_replace($search, $replace, $templateContent);
    }

    protected function getTemplate($template)
    {
        return $this->loadTemplate($template);
    }

    protected function getReplaceTemplate($template, $params)
    {
        return $this->replaceTemplate($this->loadTemplate($template), $params);
    }

    protected function getWithBaseUrl($path)
    {
        return static::$baseUrl . $path;
    }

    public static function setBaseUrl($url)
    {
        static::$baseUrl = $url;
    }

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function show()
    {
        echo $this->content;
    }

    abstract public function execute();
}
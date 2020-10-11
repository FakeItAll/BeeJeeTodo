<?php

namespace App\Views;

abstract class View
{
    protected static $baseUrl = '/';
    private $templatesDir = 'assets';
    protected $templatesSubDir = '';
    protected $params = [];
    protected $content = '';

    private function loadTemplate($template)
    {
        $fullPath = $this->templatesDir . '/' . $this->templatesSubDir . '/' . $template . '.html';
        return file_get_contents($fullPath);
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

    protected function getUrl($path, $params = [])
    {
        $getParams = '';
        if ($params) {
            $getParams = '?' . http_build_query($params);
        }
        return substr(static::$baseUrl, 0,  - 1) . $path . $getParams;
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
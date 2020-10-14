<?php

namespace App\Views;

abstract class View
{
    private $templatesDir;
    protected $baseUrl;

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

    protected function getUrl($path, $params = [], $save = false, $excludes = [])
    {
        if ($save) {
            $curParams = [];
            parse_str(parse_url($_SERVER['REQUEST_URI'])['query'] ?? '', $curParams);
            foreach ($excludes as $exclude) {
                unset($curParams[$exclude]);
            }
            $params = array_merge($curParams, $params);
        }
        $getParams = '';
        if ($params) {
            $getParams = '?' . http_build_query($params);
        }
        return substr($this->baseUrl, 0,  - 1) . $path . $getParams;
    }

    public function __construct($params = [])
    {
        $this->baseUrl = env('BASE_URL', '/');
        $this->templatesDir = env('TEMPLATES_DIR', 'assets');
        $this->params = $params;
    }

    public function show()
    {
        echo $this->content;
    }

    abstract public function execute();
}
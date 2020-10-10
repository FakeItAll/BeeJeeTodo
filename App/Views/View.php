<?php

namespace App\Views;

abstract class View
{
    private $templatesDir = 'templates/';
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

    protected function prepareLayout($params)
    {
        return [
            'title' => $params['title'] ?? '',
            'desciption' => $params['description'] ?? '',
            'content' => $params['content'] ?? ''
        ];
    }

    public function show()
    {
        echo $this->content;
    }
}
<?php


class View
{
    private $layoutTemplateName = 'layout';
    private $contentMacros = 'content';

    private function loadTemplate($template)
    {
        return file_get_contents('/templates/' . $template . '.php');
    }

    private function replaceTemplate($template_content, $params)
    {
        return str_replace($template_content, array_keys($params), array_values($params));
    }

    public function __construct($template, $params)
    {
        $content = $this->replaceTemplate($this->loadTemplate($template), $params);
        $layoutParams = array_merge([$this->contentMacros => $content], $params);
        return $this->replaceTemplate($this->loadTemplate($this->layoutTemplateName), $layoutParams);
    }
}
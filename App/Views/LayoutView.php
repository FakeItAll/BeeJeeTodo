<?php


namespace App\Views;


class LayoutView extends View
{
    protected function prepareLayout($params)
    {
        $result = [
            'title' => $params['title'] ?? '',
            'desciption' => $params['description'] ?? '',
            'content' => $params['content'] ?? '',
            'error' => $params['error'],
        ];
        return $result;
    }

    protected function prepareError($param)
    {
        switch ($param) {
            case 'emptyData':
                $value = 'Заполните все поля!';
                break;
            case 'authFailed':
                $value = 'Неправильный логин и/или пароль!';
                break;
            case 'accessDenied':
                $value = 'Доступ запрещен!';
                break;
            default:
                $value = 'Неизвестная ошибка!';
        }
        return ['message' => $value];
    }

    public function execute()
    {
        $this->params['error'] = '';
        if (!empty($this->params['responce'])) {
            $this->params['error'] = $this->getReplaceTemplate(
                'error',
                $this->prepareError($this->params['responce'])
            );
        }
        $this->content = $this->getReplaceTemplate(
            'layout', $this->prepareLayout($this->params)
        );
        return $this->content;
    }
}
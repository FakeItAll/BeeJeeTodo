<?php


namespace App\Views;

use App\Models\TodosModel;

class PaginationView extends View
{
    protected $templatesSubDir = 'todo/pagination';

    protected function preparePaginators()
    {
        $allCount = TodosModel::allCount();
        $itemsCount = TodosModel::$itemsCount;
        $page = TodosModel::$page;
        $pagesCount = (int)((($allCount - 1) / $itemsCount) + 1);

        $this->params = [];
        for ($i = 1; $i <= $pagesCount; ++$i) {
            $this->params[] = [
                'url' => $this->getUrl('/', ['page' => $i], true),
                'number' => $i,
                'active' => $i - 1 == $page
            ];
        }
    }

    public function execute()
    {
        $this->preparePaginators();
        $paginators = [];
        foreach ($this->params as $paginator) {
            $paginators[] = $this->getReplaceTemplate($paginator['active'] ? 'active' : 'item', $paginator);
        }
        $containerParams = ['paginators' => implode('', $paginators)];
        return $this->getReplaceTemplate('container', $containerParams);
    }
}
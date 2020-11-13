<?php

namespace COL\Library\Infrastructure\Common\View;

abstract class AbstractMultipleObjectViewPresenter implements MultipleObjectViewPresenterInterface
{
    protected function formatWithPagination(array $models, ?int $nbTotal, ?int $pageNumber, ?int $nbPerPage): array
    {
        $lastPage = floor($nbTotal / $nbPerPage);

        return [
            'data' => $models,
            'pagination' => [
                'nbObjects' => $nbTotal,
                'currentPage' => $pageNumber,
                'lastPage' => 0 == $lastPage ? 1 : $lastPage,
                'nbPerPage' => $nbPerPage
            ]
        ];
    }
}
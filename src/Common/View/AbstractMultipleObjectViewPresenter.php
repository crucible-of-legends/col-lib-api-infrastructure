<?php

namespace COL\Library\Infrastructure\Common\View;

abstract class AbstractMultipleObjectViewPresenter implements MultipleObjectViewPresenterInterface
{
    protected function formatWithPagination(array $models, ?int $nbTotal, ?int $pageNumber, ?int $nbPerPage): array
    {
        return [
            'data' => $models,
            'pagination' => [
                'total' => $nbTotal,
                'page' => $pageNumber,
                'nbPerPage' => $nbPerPage
            ]
        ];
    }
}
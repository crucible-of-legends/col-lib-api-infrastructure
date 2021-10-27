<?php

namespace COL\Library\Infrastructure\Common\View\ViewDecorator;

use COL\Librairy\BaseContracts\Domain\View\Decorator\ViewDecoratorInterface;
use COL\Library\ApiContracts\Domain\View\Decor\PaginationViewDecor;

final class PaginationViewDecorator implements ViewDecoratorInterface
{
    public function decorate(?int $nbTotal, ?int $pageNumber, ?int $nbPerPage): PaginationViewDecor
    {
        $lastPage = floor($nbTotal / $nbPerPage);

        $pagination = new PaginationViewDecor();
        $pagination->totalObjects = $nbTotal;
        $pagination->currentPageNumber = $pageNumber;
        $pagination->lastPageNumber = 0 === $lastPage ? 1 : $lastPage;
        $pagination->objectsPerPage = $nbPerPage;

        return $pagination;
    }
}

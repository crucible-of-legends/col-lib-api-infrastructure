<?php

namespace COL\Library\Infrastructure\Common\UseCase;

use COL\Library\Contracts\View\Wrapper\MultipleViewModelWrapper;

interface GetManyUseCaseInterface
{
    public function execute(string $displayFormat, array $criteria = [], ?int $pageNumber = null, ?int $nbPerPage = null): MultipleViewModelWrapper;
}
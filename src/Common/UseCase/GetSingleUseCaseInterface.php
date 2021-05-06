<?php

namespace COL\Library\Infrastructure\Common\UseCase;

use COL\Library\Contracts\View\Wrapper\SingleViewModelWrapper;

interface GetSingleUseCaseInterface
{
    /**
     * @param string|int      $id
     */
    public function execute($id, array $extraParameters = []): SingleViewModelWrapper;
}
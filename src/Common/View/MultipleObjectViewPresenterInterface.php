<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface MultipleObjectViewPresenterInterface
{
    /**
     * @param BaseDTOInterface[] $dtos
     *
     * @return BaseViewModelInterface[]
     */
    public function buildMultipleObjectVueModel(array $dtos): array;
}
<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface SingleObjectViewPresenterInterface
{
    public function buildSingleObjectVueModel(BaseDTOInterface $dto, ?string $displayFormat = null): BaseViewModelInterface;

    public function buildVueModelSmallFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelMediumFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelLargeFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;
}
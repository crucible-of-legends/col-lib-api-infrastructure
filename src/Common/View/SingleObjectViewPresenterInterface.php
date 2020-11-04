<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface SingleObjectViewPresenterInterface
{
    public function buildSingleObjectVueModel(BaseDTOInterface $dto): BaseViewModelInterface;
}
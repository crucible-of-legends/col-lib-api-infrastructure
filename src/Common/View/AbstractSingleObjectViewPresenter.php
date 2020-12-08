<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use COL\Library\Infrastructure\Common\Exception\NotImplementedException;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;

abstract class AbstractSingleObjectViewPresenter implements SingleObjectViewPresenterInterface
{
    public function buildSingleObjectVueModel(
        BaseDTOInterface $dto,
        ?string $displayFormat = DisplayFormatRegistry::DISPLAY_FORMAT_SMALL
    ): BaseViewModelInterface {
        $model = null;
        if (DisplayFormatRegistry::DISPLAY_FORMAT_LARGE === $displayFormat) {
            $model = $this->buildVueModelLargeFormat($dto);
        } elseif(DisplayFormatRegistry::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
            $model = $this->buildVueModelMediumFormat($dto);
        } else {
            $model = $this->buildVueModelSmallFormat($dto);
        }

        return $model;
    }

    public function buildVueModelSmallFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface
    {
        throw new NotImplementedException(get_class($this), "buildVueModelSmallFormat");
    }

    public function buildVueModelMediumFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface
    {
        throw new NotImplementedException(get_class($this), "buildVueModelSmallFormat");
    }

    public function buildVueModelLargeFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface
    {
        throw new NotImplementedException(get_class($this), "buildVueModelSmallFormat");
    }
}
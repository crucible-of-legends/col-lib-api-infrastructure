<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Contracts\View\Wrapper\SingleViewModelWrapper;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use COL\Library\Infrastructure\Common\Exception\NotImplementedException;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;

abstract class AbstractSingleObjectViewPresenter implements SingleObjectViewPresenterInterface
{
    protected array $displayFormats;

    public function __construct(array $displayFormats = [])
    {
        $this->displayFormats = $displayFormats;
    }

    public function buildSingleObjectVueModel(
        BaseDTOInterface $dto,
        ?string $displayFormat = DisplayFormatRegistry::DISPLAY_FORMAT_SMALL
    ): SingleViewModelWrapper {
        $model = null;
        if (DisplayFormatRegistry::DISPLAY_FORMAT_LARGE === $displayFormat) {
            $model = $this->buildVueModelLargeFormat($dto);
        } elseif(DisplayFormatRegistry::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
            $model = $this->buildVueModelMediumFormat($dto);
        } else {
            $model = $this->buildVueModelSmallFormat($dto);
        }

        return $this->wrap($model);
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

    private function wrap(BaseViewModelInterface $model): SingleViewModelWrapper
    {
        $wrapper = new SingleViewModelWrapper();

        $wrapper->data = $model;

        return $wrapper;
    }
}
<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use COL\Librairy\BaseContracts\Domain\View\Model\ViewModelInterface;
use COL\Librairy\BaseContracts\Domain\View\Presenter\SingleObjectViewPresenterInterface;
use COL\Library\ApiContracts\Domain\View\Wrapper\SingleViewModelWrapper;
use COL\Library\Infrastructure\Common\Exception\NotImplementedException;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;
use COL\Library\Infrastructure\Common\View\ViewDecorator\ErrorViewDecorator;

abstract class AbstractSingleObjectViewPresenter implements SingleObjectViewPresenterInterface
{
    public function __construct(private ErrorViewDecorator $errorDecorator)
    {
    }

    public function buildSingleObjectVueModel(
        ?DTOInterface $dto,
        ?string $displayFormat = DisplayFormatRegistry::DISPLAY_FORMAT_SMALL,
    ): SingleViewModelWrapper {
        if (null === $dto) {
            return $this->wrap(null);
        }

        if (DisplayFormatRegistry::DISPLAY_FORMAT_LARGE === $displayFormat) {
            $model = $this->buildVueModelLargeFormat($dto);
        } elseif (DisplayFormatRegistry::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
            $model = $this->buildVueModelMediumFormat($dto);
        } else {
            $model = $this->buildVueModelSmallFormat($dto);
        }

        return $this->wrap($model);
    }

    public function buildVueModelSmallFormat(DTOInterface $baseDTO): ViewModelInterface
    {
        throw new NotImplementedException(get_class($this), 'buildVueModelSmallFormat');
    }

    public function buildVueModelMediumFormat(DTOInterface $baseDTO): ViewModelInterface
    {
        throw new NotImplementedException(get_class($this), 'buildVueModelSmallFormat');
    }

    public function buildVueModelLargeFormat(DTOInterface $baseDTO): ViewModelInterface
    {
        throw new NotImplementedException(get_class($this), 'buildVueModelSmallFormat');
    }

    private function wrap(?ViewModelInterface $model): SingleViewModelWrapper
    {
        $wrapper = new SingleViewModelWrapper();

        $wrapper->data = $model;
        $wrapper->error = $this->errorDecorator->decorate($wrapper->data, false);

        return $wrapper;
    }
}

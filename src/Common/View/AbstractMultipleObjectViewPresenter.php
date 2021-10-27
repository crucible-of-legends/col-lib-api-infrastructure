<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use COL\Librairy\BaseContracts\Domain\View\Presenter\MultipleObjectViewPresenterInterface;
use COL\Library\ApiContracts\Domain\View\Wrapper\MultipleViewModelWrapper;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;
use COL\Library\Infrastructure\Common\View\ViewDecorator\PaginationViewDecorator;

abstract class AbstractMultipleObjectViewPresenter implements MultipleObjectViewPresenterInterface
{
    private const DEFAULT_PAGE_NUMBER = 1;
    private const DEFAULT_NB_PER_PAGE = 20;

    public function __construct(private PaginationViewDecorator $paginationDecorator)
    {
    }

    /**
     * @param DTOInterface[] $dtos
     */
    public function buildMultipleObjectVueModel(
        array $dtos,
        string $displayFormat = DisplayFormatRegistry::DISPLAY_FORMAT_SMALL,
        ?int $nbTotal = null,
        ?int $pageNumber = null,
        ?int $nbPerPage = null,
    ): MultipleViewModelWrapper {
        $models = [];
        foreach ($dtos as $dto) {
            if (DisplayFormatRegistry::DISPLAY_FORMAT_LARGE === $displayFormat) {
                $models[] = $this->buildVueModelLargeFormat($dto);
            } elseif (DisplayFormatRegistry::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
                $models[] = $this->buildVueModelMediumFormat($dto);
            } else {
                $models[] = $this->buildVueModelSmallFormat($dto);
            }
        }

        if (null === $pageNumber) {
            $pageNumber = self::DEFAULT_PAGE_NUMBER;
        }

        if (null === $nbPerPage) {
            $nbPerPage = self::DEFAULT_NB_PER_PAGE;
        }

        return $this->wrap($models, $nbTotal, $pageNumber, $nbPerPage);
    }

    private function wrap(array $models, ?int $nbTotal, ?int $pageNumber, ?int $nbPerPage): MultipleViewModelWrapper
    {
        $wrapper = new MultipleViewModelWrapper();

        $wrapper->data = $models;
        $wrapper->pagination = $this->paginationDecorator->decorate($nbTotal, $pageNumber, $nbPerPage);

        return $wrapper;
    }
}

<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;

abstract class AbstractMultipleObjectViewPresenter implements MultipleObjectViewPresenterInterface
{
    /**
     * @param BaseDTOInterface[] $dtos
     *
     * @return BaseViewModelInterface[]
     */
    public function buildMultipleObjectVueModel(
        array $dtos,
        string $displayFormat = DisplayFormatRegistry::DISPLAY_FORMAT_SMALL,
        ?int $nbTotal = null,
        ?int $pageNumber = null,
        ?int $nbPerPage = null
    ): array
    {
        $models = [];
        foreach ($dtos as $dto) {
            if (DisplayFormatRegistry::DISPLAY_FORMAT_LARGE === $displayFormat) {
                $models[] = $this->buildVueModelLargeFormat($dto);
            } elseif(DisplayFormatRegistry::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
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

        return $this->formatWithPagination($models, $nbTotal, $pageNumber, $nbPerPage);
    }

    protected function formatWithPagination(array $models, ?int $nbTotal, ?int $pageNumber, ?int $nbPerPage): array
    {
        $lastPage = floor($nbTotal / $nbPerPage);

        return [
            'data' => $models,
            'pagination' => [
                'nbObjects' => $nbTotal,
                'currentPage' => $pageNumber,
                'lastPage' => 0 == $lastPage ? 1 : $lastPage,
                'nbPerPage' => $nbPerPage
            ]
        ];
    }
}
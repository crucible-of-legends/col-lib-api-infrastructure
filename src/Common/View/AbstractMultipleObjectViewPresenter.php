<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

abstract class AbstractMultipleObjectViewPresenter implements MultipleObjectViewPresenterInterface
{
    /**
     * @param BaseDTOInterface[] $dtos
     *
     * @return BaseViewModelInterface[]
     */
    public function buildMultipleObjectVueModel(array $dtos, string $displayFormat, ?int $nbTotal = null, ?int $pageNumber = null, ?int $nbPerPage = null): array
    {
        $models = [];
        foreach ($dtos as $dto) {
            if (self::DISPLAY_FORMAT_LARGE === $displayFormat) {
                $models[] = $this->buildVueModelLargeFormat($dto);
            } elseif(self::DISPLAY_FORMAT_MEDIUM === $displayFormat) {
                $models[] = $this->buildVueModelMediumFormat($dto);
            } else {
                $models[] = $this->buildVueModelSmallFormat($dto);
            }
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
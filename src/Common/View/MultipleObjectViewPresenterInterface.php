<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface MultipleObjectViewPresenterInterface
{
    public const DISPLAY_FORMAT_SMALL = 'small';
    public const DISPLAY_FORMAT_MEDIUM = 'medium';
    public const DISPLAY_FORMAT_LARGE = 'large';

    public const DEFAULT_PAGE_NUMBER = 1;
    public const DEFAULT_NB_PER_PAGE = 50;

    /**
     * @param BaseDTOInterface[] $dtos
     *
     * @return BaseViewModelInterface[]
     */
    public function buildMultipleObjectVueModel(
        array $dtos,
        string $displayFormat,
        ?int $nbTotal = null,
        ?int $pageNumber = null,
        ?int $nbPerPage = null
    ): array;

    public function buildVueModelSmallFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelMediumFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelLargeFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;
}
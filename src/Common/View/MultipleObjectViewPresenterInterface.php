<?php

namespace COL\Library\Infrastructure\Common\View;

use COL\Library\Contracts\View\Model\BaseViewModelInterface;
use COL\Library\Contracts\View\Wrapper\MultipleViewModelWrapper;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use COL\Library\Infrastructure\Common\Registry\DisplayFormatRegistry;

interface MultipleObjectViewPresenterInterface
{
    public const DEFAULT_PAGE_NUMBER = 1;
    public const DEFAULT_NB_PER_PAGE = 50;

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
    ): MultipleViewModelWrapper;

    public function buildVueModelSmallFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelMediumFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;

    public function buildVueModelLargeFormat(BaseDTOInterface $baseDTO): BaseViewModelInterface;
}
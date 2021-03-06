<?php

namespace COL\Library\Infrastructure\Adapter\Database;

use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface QueryBuilderAdapterInterface
{
    public function addCount(string $objectAlias, string $fieldName): void;

    public function pagination(int $pageNumber, int $nbPerPage): void;

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void;

    /**
     * @return BaseDTOInterface[]
     */
    public function getMultipleResults(): array;

    public function getSingleResult(): ?BaseDTOInterface;

    public function getCountResult(): int;

    public function exists(): bool;

    public function limit(int $limit): void;
}
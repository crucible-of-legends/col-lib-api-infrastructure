<?php

namespace COL\Library\Infrastructure\Database;

use COL\Library\Tools\DTO\BaseDTOInterface;

interface QueryBuilderAdapterInterface
{
    public function addWhere(string $condition, string $parameterField, $parameterValue): void;

    public function limit(?int $limit = null): void;

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void;

    /**
     * @return BaseDTOInterface[]
     */
    public function getMultipleResults(): array;

    public function getSingleResult(): ?BaseDTOInterface;
}
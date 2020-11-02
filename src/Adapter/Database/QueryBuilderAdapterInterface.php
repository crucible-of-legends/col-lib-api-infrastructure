<?php

namespace COL\Library\Infrastructure\Database;

interface QueryBuilderAdapterInterface
{
    public function addWhere(string $fieldName, $value): void;

    public function limit(?int $limit = null): void;

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void;

    /**
     * @return BaseDTOInterface[]
     */
    public function getMultipleResults(): array;

    public function getSingleResult(): ?BaseDTOInterface;
}
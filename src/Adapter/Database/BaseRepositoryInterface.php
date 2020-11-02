<?php

namespace COL\Library\Infrastructure\Database;

interface BaseRepositoryInterface
{
    /**
     * @return BaseDTOInterface[]
     */
    public function findManyByCriteria(
        array $criteria = [],
        array $selects = [],
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null
    ): array;

    public function findOneByCriteria(array $criteria, array $selects = []): ?BaseDTOInterface;
}
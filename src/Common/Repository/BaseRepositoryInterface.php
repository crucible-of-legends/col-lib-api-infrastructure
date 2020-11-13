<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface BaseRepositoryInterface
{
    public const ORDER_DIRECTION_ASC  = 'ASC';
    public const ORDER_DIRECTION_DESC = 'DESC';

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

    public function findManyByCriteriaBuilder(
        array $criteria = [],
        array $selects = [],
        array $orders = []
    ): QueryBuilderAdapterInterface;

    public function findOneByCriteria(array $criteria, array $selects = []): ?BaseDTOInterface;

    public function countByCriteria(array $criteria = []): int;
}
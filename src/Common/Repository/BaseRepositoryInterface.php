<?php

namespace COL\Library\Tools\Repository;

use COL\Library\Infrastructure\Database\QueryBuilderAdapterInterface;
use COL\Library\Common\DTO\BaseDTOInterface;

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
}
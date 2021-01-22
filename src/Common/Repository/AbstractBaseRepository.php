<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

abstract class AbstractBaseRepository implements BaseRepositoryInterface
{
    private DatabaseAdapterInterface $databaseAdapter;

    public function __construct(DatabaseAdapterInterface $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    abstract protected function getDTOClassName(): string;

    /**
     * @return BaseDTOInterface[]
     */
    public function findManyByCriteria(
        array $criteria = [],
        array $selects = [],
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null
    ): array
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addOrderBys($queryBuilder, $orders)
             ->addSelects($queryBuilder, $selects);

        $queryBuilder->limit($limit);

        return $queryBuilder->getMultipleResults();
    }

    public function findOneByCriteria(
        array $criteria,
        array $selects = []
    ): ?BaseDTOInterface
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $this->addCriteria($queryBuilder, $criteria)
             ->addSelects($queryBuilder, $selects);

        return $queryBuilder->getSingleResult();
    }

    public function exists(array $criteria): bool
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $this->addCriteria($queryBuilder, $criteria);

        return $queryBuilder->exists();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                        BATCH OPERATIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function addCriteria(QueryBuilderAdapterInterface $queryBuilder, array $criteria = []): self
    {
        foreach ($criteria as $field => $value) {
            if ($field) {
                $this->{'addCriterion' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    protected function addSelects(QueryBuilderAdapterInterface $queryBuilder, array $selects = []): self
    {
        foreach ($selects as $field => $value) {
            if ($field) {
                $this->{'addSelect' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    protected function addOrderBys(QueryBuilderAdapterInterface $queryBuilder, array $orderBys = []): self
    {
        foreach ($orderBys as $orderBy => $direction) {
            if ($orderBy) {
                $this->{'addOrderBy' . ucfirst($orderBy)}($queryBuilder, $direction);
            }
        }

        return $this;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                        UNIT OPERATIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function addOrderBy(QueryBuilderAdapterInterface $queryBuilder, $fieldName, $direction): void
    {
        if (false === in_array($direction, [self::ORDER_DIRECTION_DESC, self::ORDER_DIRECTION_ASC], true)) {
            throw new \LogicException("$direction is not a valid value for order by 'direction' parameter.");
        }

        $queryBuilder->addOrderBy($fieldName, $direction);
    }

    private function addGenericCriteria(array $criteria = []): array
    {
        if (false === isset($criteria['status']) && property_exists($this->getDTOClassName(), 'status')) {
            $excludedStatus             = isset($criteria['excludedStatus']) ?? $criteria['excludedStatus'];
            $excludedStatus             = is_array($excludedStatus) ? $excludedStatus : [$excludedStatus];
            $criteria['excludedStatus'] = array_merge([BaseDTOInterface::STATUS_DELETED], $excludedStatus);
        }
        return $criteria;
    }
}
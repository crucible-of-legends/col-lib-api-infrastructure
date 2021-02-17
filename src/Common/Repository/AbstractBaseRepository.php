<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

abstract class AbstractBaseRepository implements BaseRepositoryInterface
{
    private DatabaseAdapterInterface $databaseAdapter;
    private ?string $dtoAlias = null;

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
        ?int $pageNumber = null,
        ?int $nbPerPage = null
    ): array
    {
        $queryBuilder = $this->findManyByCriteriaBuilder($criteria, $selects, $orders);
        $queryBuilder->pagination($pageNumber, $nbPerPage);

        return $queryBuilder->getMultipleResults();
    }

    public function findManyByCriteriaBuilder(
        array $criteria = [],
        array $selects = [],
        array $orders = []
    ): QueryBuilderAdapterInterface
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addOrderBys($queryBuilder, $orders)
             ->addSelects($queryBuilder, $selects);

        return $queryBuilder;
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

    public function countByCriteria(array $criteria = []): int
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $queryBuilder->addCount($this->getAlias(), 'id');
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria));

        return $queryBuilder->getCountResult();
    }

    public function exists(array $criteria): bool
    {
        $queryBuilder = $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), '');
        $this->addCriteria($queryBuilder, $criteria);

        return $queryBuilder->exists();
    }

    protected function getAlias(): string
    {
        if (null === $this->dtoAlias) {
            $last = explode('\\', $this->getDTOClassName());
            $this->dtoAlias = lcfirst(end($last));
        }

        return  $this->dtoAlias;
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                        COMMON CRITERIA
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function addCriterionId(QueryBuilderAdapterInterface $queryBuilder, $id): bool
    {
        return $this->addCriterion($queryBuilder, 'id', $id);
    }

    public function addCriterionExcludedStatus(QueryBuilderAdapterInterface $queryBuilder, $excludedStatus): bool
    {
        return $this->addCriterion($queryBuilder, 'status', $excludedStatus, $this->getAlias(),true);
    }

    public function addCriterionStatus(QueryBuilderAdapterInterface $queryBuilder, $status): bool
    {
        return $this->addCriterion($queryBuilder, 'status', $status);
    }
}
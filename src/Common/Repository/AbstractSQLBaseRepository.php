<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;
use COL\Library\Infrastructure\Adapter\Database\SQL\SQLDatabaseAdapter;
use COL\Library\Infrastructure\Adapter\Database\SQL\SQLQueryBuilderAdapter;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

abstract class AbstractSQLBaseRepository implements BaseRepositoryInterface
{
    private SQLDatabaseAdapter $databaseAdapter;
    private ?string $dtoAlias = null;

    public function __construct(SQLDatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    abstract protected function getDTOClassName(): string;

    /**
     * {@inheritdoc}
     */
    public function findOneByCriteria(array $criteria = [], array $selects = []): BaseDTOInterface
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addSelects($queryBuilder, $selects);

        $queryBuilder->cleanQueryBuilder();

        return $queryBuilder->getSingleResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findManyByCriteriaBuilder(array $criteria = [], array $selects = [], array $orders = []): QueryBuilderAdapterInterface
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addOrderBys($queryBuilder, $orders)
             ->addSelects($queryBuilder, $selects);

        $queryBuilder->cleanQueryBuilder();

        return $queryBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function findManyByCriteria(
        array $criteria = [],
        array $selects = [],
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null
    ): array
    {
        $queryBuilder = $this->findManyByCriteriaBuilder($criteria, $selects, $orders);
        if ($limit) {
            $queryBuilder->limit($limit);
        }

        return $queryBuilder->getMultipleResults();
    }

    public function countByCriteria(array $criteria = []): int
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->addCount($this->getAlias(), 'id');
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria));

        return $queryBuilder->getCountResult();
    }

    protected function getQueryBuilder(): SQLQueryBuilderAdapter
    {
        return $this->databaseAdapter->createQueryBuilder($this->getDTOClassName(), $this->getAlias());
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
        foreach ($selects as $select) {
            if ($select) {
                $this->{'addSelect' . ucfirst($select)}($queryBuilder);
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
    protected function addCriterion(QueryBuilderAdapterInterface $queryBuilder, $alias, $fieldName, $value, $exclude = false): bool
    {
        [$condition, $parameterField, $parameterValue] = $this->computeCriterionCondition($alias, $fieldName, $value, $exclude);
        if (null === $condition) {
            return false;
        }

        $queryBuilder->addWhere($condition, $parameterField, $parameterValue);

        return true;
    }

    private function computeCriterionCondition($alias, $fieldName, $value, $exclude = false): array
    {
        if (null === $value) {
            return [null, null, null];
        }

        $operator       = $exclude ? '!=' : '=';
        $condition      = $alias . '.' . $fieldName . ' ' . $operator . ' :' . $alias . '_' . $fieldName;
        $parameterField = $alias . '_' . $fieldName;
        $parameterValue = $value !== false && empty($value) ? null : $value;
        if (is_array($value)) {
            $operator  = $exclude ? 'NOT IN' : 'IN';
            $condition = $alias . '.' . $fieldName . ' ' . $operator . ' (:' . $alias . '_' . $fieldName . ')';
        } elseif ('NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NULL';
            $parameterField = null;
            $parameterValue = null;
        } elseif ('NOT NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NOT NULL';
            $parameterField = null;
            $parameterValue = null;
        }

        return [$condition, $parameterField, $parameterValue];
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
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'id', $id);
    }

    public function addCriterionExcludedStatus(QueryBuilderAdapterInterface $queryBuilder, $excludedStatus): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $excludedStatus, true);
    }

    public function addCriterionStatus(QueryBuilderAdapterInterface $queryBuilder, $status): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $status);
    }
}

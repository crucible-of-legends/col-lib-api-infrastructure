<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Clock\ClockInterface;
use COL\Library\Infrastructure\Database\BaseDTOInterface;
use COL\Library\Infrastructure\Database\BaseRepositoryInterface;

abstract class AbstractSQLBaseRepository implements BaseRepositoryInterface
{
    public const ORDER_DIRECTION_ASC  = 'ASC';
    public const ORDER_DIRECTION_DESC = 'DESC';

    protected ClockInterface $clock;
    private SQLDatabaseAdapter $databaseAdapter;

    public function __construct(ClockInterface $clock, SQLDatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
        $this->clock = $clock;
    }

    public function flush(): void
    {
        $this->databaseAdapter->flush();
    }

    public function persist(AbstractSQLBaseDTO $dto): void
    {
        if ($dto->isNew()) {
            $dto->setStatus($dto->getDefaultStatus());
            $dto->setCreatedDate($this->clock->now());
        }
        $dto->setUpdatedDate($this->clock->now());

        $this->databaseAdapter->persist($dto);
    }


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

    }

    public function findOneByCriteria(array $criteria, array $selects = []): ?BaseDTOInterface
    {

    }

    public function exists(array $criteria): bool
    {

    }

    protected function addCriteria(SQLQueryBuilderAdapter $queryBuilder, array $criteria = []): self
    {
        foreach ($criteria as $field => $value) {
            if ($field) {
                $this->{'addCriterion' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    protected function addSelects(SQLQueryBuilderAdapter $queryBuilder, array $selects = []): self
    {
        foreach ($selects as $field => $value) {
            if ($field) {
                $this->{'addSelect' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    protected function addCriterion(SQLQueryBuilderAdapter $queryBuilder, string $fieldName, $value, bool $exclude = false): bool
    {
        if (null === $value) {
            return false;
        }

        // TODO : fill it

        return true;
    }

    protected function addOrderBys(SQLQueryBuilderAdapter $queryBuilder, array $orderBys = []): self
    {
        foreach ($orderBys as $orderBy => $direction) {
            if ($orderBy) {
                $this->{'addOrderBy' . ucfirst($orderBy)}($queryBuilder, $direction);
            }
        }

        return $this;
    }

    protected function addOrderBy(SQLQueryBuilderAdapter $queryBuilder, $fieldName, $direction): void
    {
        if (false === in_array($direction, [self::ORDER_DIRECTION_DESC, self::ORDER_DIRECTION_ASC], true)) {
            throw new \LogicException("$direction is not a valid value for order by 'direction' parameter.");
        }

        $queryBuilder->addOrderBy($fieldName, $direction);
    }

    protected function addSelect(SQLQueryBuilderAdapter $queryBuilder, $fieldName): void
    {
        $queryBuilder->addSelect($fieldName);
    }

    protected function addCriterionId(SQLQueryBuilderAdapter $queryBuilder, $id): bool
    {
        return $this->addCriterion($queryBuilder, 'id', $id);
    }

    protected function addCriterionStatus(SQLQueryBuilderAdapter $queryBuilder, $status): bool
    {
        return $this->addCriterion($queryBuilder, 'status', $status);
    }
}
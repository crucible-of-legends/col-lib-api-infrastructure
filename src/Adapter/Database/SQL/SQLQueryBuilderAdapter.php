<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Database\BaseDTOInterface;
use COL\Library\Infrastructure\Database\QueryBuilderAdapterInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

final class SQLQueryBuilderAdapter implements QueryBuilderAdapterInterface
{
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function addWhere(string $fieldName, $value): void
    {
        $this->queryBuilder->andWhere("$fieldName = $value");
    }

    public function limit(?int $limit = null): void
    {
        if (null !== $limit) {
            $this->queryBuilder->setMaxResults($limit);
        }
    }

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void
    {
        $this->queryBuilder->addOrderBy($fieldName, 'ASC' === $direction ? 0 : 1);
    }

    public function addSelect(string $fieldName): void
    {
        $this->queryBuilder->addSelect($fieldName);
    }

    /**
     * @return BaseDTOInterface[]
     */
    public function getMultipleResults(): array
    {
        $result = $this->queryBuilder->getQuery()->getResult();

        return null === $result ? [] : $result->toArray();
    }

    public function getSingleResult(): ?BaseDTOInterface
    {
        try {
            return $this->queryBuilder->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            // TODO: Do something with that !
        }

        return null;
    }
}
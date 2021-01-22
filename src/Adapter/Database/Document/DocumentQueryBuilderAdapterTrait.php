<?php

namespace COL\Library\Infrastructure\Adapter\Database\Document;

use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

trait DocumentQueryBuilderAdapterTrait
{
    public function equals(string $fieldName, $value): void
    {
        if ($value instanceof BaseDTOInterface) {
            $this->queryBuilder->field($fieldName)->references($value);
        } else {
            $this->queryBuilder->field($fieldName)->equals($value);
        }
    }

    public function limit(?int $limit = null): void
    {
        if (null !== $limit) {
            $this->queryBuilder->limit($limit);
        }
    }

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void
    {
        $this->queryBuilder->sort($fieldName, 'ASC' === $direction ? 0 : 1);
    }

    public function addSelect(string $fieldName): void
    {
        $this->queryBuilder->select($fieldName);
    }

    /**
     * @return BaseDTOInterface[]
     */
    public function getMultipleResults(): array
    {
        $result = $this->queryBuilder->getQuery()->execute();

        return null === $result ? [] : $result->toArray();
    }

    /**
     * @return BaseDTOInterface|null|object
     */
    public function getSingleResult(): ?BaseDTOInterface
    {
        return $this->queryBuilder->getQuery()->getSingleResult();
    }

    public function exists(): bool
    {
        $this->queryBuilder->count();

        return 0 < $this->queryBuilder->getQuery()->execute();
    }

    public function addWhere(string $condition, string $parameterField, $parameterValue): void
    {
        // TODO: Implement addWhere() method.
    }

    public function addCount(string $objectAlias, string $fieldName): void
    {
        // TODO: Implement addCount() method.
    }

    public function pagination(int $pageNumber, int $nbPerPage): void
    {
        // TODO: Implement pagination() method.
    }

    public function getCountResult(): int
    {
        // TODO: Implement getCountResult() method.
    }
}
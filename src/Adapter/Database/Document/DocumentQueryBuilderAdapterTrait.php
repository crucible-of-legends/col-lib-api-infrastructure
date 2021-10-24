<?php

namespace COL\Library\Infrastructure\Adapter\Database\Document;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;

trait DocumentQueryBuilderAdapterTrait
{
    public function equals(string $fieldName, $value): void
    {
        if ($value instanceof DTOInterface) {
            $this->queryBuilder->field($fieldName)->references($value);
        } else {
            $this->queryBuilder->field($fieldName)->equals($value);
        }
    }

    public function notEquals(string $fieldName, $value): void
    {
        $this->queryBuilder->field($fieldName)->notEqual($value);
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
     * @return DTOInterface[]
     */
    public function getMultipleResults(): array
    {
        $result = $this->queryBuilder->getQuery()->execute();

        return null === $result ? [] : $result->toArray();
    }

    /**
     * @return DTOInterface|null|object
     */
    public function getSingleResult(): ?DTOInterface
    {
        return $this->queryBuilder->getQuery()->getSingleResult();
    }

    public function exists(): bool
    {
        $this->queryBuilder->count();

        return 0 < $this->queryBuilder->getQuery()->execute();
    }

    public function addCount(string $objectAlias, string $fieldName): void
    {
        $this->queryBuilder->count();
    }

    public function pagination(int $pageNumber, int $nbPerPage): void
    {
        $this->queryBuilder->limit($nbPerPage)
                           ->skip($nbPerPage*($pageNumber-1));
    }

    public function getCountResult(): int
    {
        return $this->queryBuilder->getQuery()->execute();
    }
}
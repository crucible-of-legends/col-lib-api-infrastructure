<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use COL\Librairy\BaseContracts\Domain\Registry\DTOStatusRegistry;

trait SQLQueryBuilderAdapterTrait
{
    public function addWhere(string $condition, ?string $parameterField, $parameterValue): void
    {
        $this->queryBuilder->andWhere($condition);
        if (null !== $parameterField) {
            $this->queryBuilder->setParameter($parameterField, $parameterValue);
        }
    }

    public function addSelect(string $objectAlias, string $fieldName): void
    {
        $joinedObjectAlias = $objectAlias . '_' . $fieldName;

        $this->queryBuilder->leftJoin($objectAlias . '.' . $fieldName, $joinedObjectAlias, $joinedObjectAlias . '.status != ' . DTOStatusRegistry::STATUS_DELETED)
                           ->addSelect($joinedObjectAlias);
    }

    public function addCount(string $objectAlias, string $fieldName): void
    {
        $this->queryBuilder->select("COUNT($objectAlias.$fieldName)");
    }

    public function pagination(int $pageNumber, int $nbPerPage): void
    {
        $this->queryBuilder->setFirstResult(($pageNumber-1)*$nbPerPage);
        $this->queryBuilder->setMaxResults($pageNumber*$nbPerPage);
    }

    public function limit(int $limit): void
    {
        $this->queryBuilder->setMaxResults($limit);
    }

    public function addOrderBy(string $fieldName, string $direction = 'ASC'): void
    {
        $this->queryBuilder->addOrderBy($fieldName, 'ASC' === $direction ? 0 : 1);
    }

    /**
     * @return DTOInterface[]
     */
    public function getMultipleResults(): array
    {
        $result = $this->queryBuilder->getQuery()->getResult();

        return null === $result ? [] : $result;
    }

    public function getSingleResult(): ?DTOInterface
    {
        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function getCountResult(): int
    {
        return $this->queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function exists(): bool
    {
        $this->queryBuilder->count();

        return 0 < $this->queryBuilder->getQuery()->execute();
    }

    public function cleanQueryBuilder(): void
    {
        $this->cleanQueryBuilderDqlPart( 'join');
        $this->cleanQueryBuilderDqlPart( 'select');
    }

    /**
     * @param string       $dqlPartName ('join', 'select', ...)
     */
    public function cleanQueryBuilderDqlPart(string $dqlPartName)
    {
        $dqlPart    = $this->queryBuilder->getDQLPart($dqlPartName);
        $newDqlPart = [];
        if (0 === count($dqlPart)) {
            return;
        }

        $this->queryBuilder->resetDQLPart($dqlPartName);
        if ('join' === $dqlPartName) {
            $this->cleanJoinFromQuery($dqlPart, $dqlPartName, $newDqlPart);
            return;
        }
        foreach ($dqlPart as $element) {
            $newDqlPart[$element->__toString()] = $element;
        }
        $dqlPart = array_values($newDqlPart);
        foreach ($dqlPart as $element) {
            $this->queryBuilder->add($dqlPartName, $element, true);
        }
    }

    private function cleanJoinFromQuery($dqlPart, string $dqlPartName, array $newDqlPart)
    {
        foreach ($dqlPart as $root => $elements) {
            foreach ($elements as $element) {
                preg_match(
                    '/^(?P<joinType>[^ ]+) JOIN (?P<join>[^ ]+) (?P<alias>[^ ]+)/',
                    $element->__toString(),
                    $matches
                );
                if (false === array_key_exists($matches['alias'], $newDqlPart)) {
                    $newDqlPart[$matches['alias']] = $element;
                }
            }
            $dqlPart[$root] = array_values($newDqlPart);
        }
        $dqlPart = array_shift($dqlPart);
        foreach ($dqlPart as $element) {
            $this->queryBuilder->add($dqlPartName, [$element], true);
        }
    }
}
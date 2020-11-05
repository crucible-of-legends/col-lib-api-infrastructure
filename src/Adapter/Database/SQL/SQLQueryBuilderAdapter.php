<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

final class SQLQueryBuilderAdapter implements QueryBuilderAdapterInterface
{
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function addWhere(string $condition, string $parameterField, $parameterValue): void
    {
        $this->queryBuilder->andWhere($condition);
        if (null !== $parameterField) {
            $this->queryBuilder->setParameter($parameterField, $parameterValue);
        }
    }

    public function addSelect(string $objectAlias, string $fieldName): void
    {
        $joinedObjectAlias = $objectAlias . '_joined_by_' . $fieldName;

        $this->queryBuilder->leftJoin($objectAlias . '.' . $fieldName, $objectAlias, $joinedObjectAlias . '.status != ' . BaseDTOInterface::STATUS_DELETED)
                            ->addSelect($joinedObjectAlias);
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
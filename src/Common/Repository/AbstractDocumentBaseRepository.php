<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;

abstract class AbstractDocumentBaseRepository extends AbstractBaseRepository
{
    abstract protected function getDTOClassName(): string;

    protected function addCriterion(QueryBuilderAdapterInterface $queryBuilder, string $fieldName, $value, bool $exclude = false): bool
    {
        if (null === $value) {
            return false;
        }

        if (true === $exclude) {
            $queryBuilder->notEquals($fieldName, $value);
        } else {
            $queryBuilder->equals($fieldName, $value);
        }

        return true;
    }
}
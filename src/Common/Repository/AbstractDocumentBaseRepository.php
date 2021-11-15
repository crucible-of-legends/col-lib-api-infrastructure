<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Librairy\BaseContracts\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;

abstract class AbstractDocumentBaseRepository extends AbstractBaseRepository
{
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

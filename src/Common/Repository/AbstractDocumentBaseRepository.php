<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Library\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use COL\Library\Infrastructure\Adapter\Database\QueryBuilderAdapterInterface;

abstract class AbstractDocumentBaseRepository
{
    private DatabaseAdapterInterface $databaseAdapter;

    public function __construct(DatabaseAdapterInterface $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    abstract protected function getDTOClassName(): string;

    protected function addCriterion(QueryBuilderAdapterInterface $queryBuilder, string $fieldName, $value, bool $exclude = false): bool
    {
        if (null === $value) {
            return false;
        }

        $queryBuilder->equals($fieldName, $value);

        return true;
    }
}
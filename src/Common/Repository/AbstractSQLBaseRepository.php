<?php

namespace COL\Library\Infrastructure\Common\Repository;

use COL\Librairy\BaseContracts\Infrastructure\Adatper\Database\QueryBuilderAdapterInterface;

abstract class AbstractSQLBaseRepository extends AbstractBaseRepository
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                        UNIT OPERATIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function addCriterion(QueryBuilderAdapterInterface $queryBuilder, string $fieldName, $value, ?string $alias = null, $exclude = false): bool
    {
        if (null === $alias) {
            $alias = $this->getAlias();
        }

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
}

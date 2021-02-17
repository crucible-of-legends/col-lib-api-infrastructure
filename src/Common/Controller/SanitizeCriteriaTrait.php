<?php

namespace COL\Library\Infrastructure\Common\Controller;

trait SanitizeCriteriaTrait
{
    protected function sanitizeCriteria(array $criteria): array
    {
        if (array_key_exists('format', $criteria)) {
            unset($criteria['format']);
        }

        if (array_key_exists('page', $criteria)) {
            unset($criteria['page']);
        }

        if (array_key_exists('nbPerPage', $criteria)) {
            unset($criteria['nbPerPage']);
        }

        return $criteria;
    }
}
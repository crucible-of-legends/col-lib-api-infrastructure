<?php

namespace COL\Library\Infrastructure\Common\Controller;

trait SanitizeCriteriaTrait
{
    protected function sanitizeCriteria(array $criteria): array
    {
        if (array_key_exists('format', $criteria)) {
            unset($criteria['format']);
        }

        return $criteria;
    }
}
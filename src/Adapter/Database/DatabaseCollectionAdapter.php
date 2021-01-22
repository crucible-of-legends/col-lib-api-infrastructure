<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

final class DatabaseCollectionAdapter
{
    public static function getDatabaseCollection($items): array
    {
        if (true === method_exists($items, 'toArray')) {
            return $items->toArray();
        }

        return $items;
    }
}
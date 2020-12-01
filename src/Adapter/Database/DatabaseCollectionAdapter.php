<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use Doctrine\ORM\PersistentCollection;

final class DatabaseCollectionAdapter
{
    public static function getDatabaseCollection($items): array
    {
        if ($items instanceof PersistentCollection) {
            return $items->toArray();
        }

        return $items;
    }
}
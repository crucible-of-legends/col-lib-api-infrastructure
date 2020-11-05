<?php

namespace COL\Library\Infrastructure\Adapter\Database;

use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;

interface DatabaseAdapterInterface
{
    public function createQueryBuilder(string $dtoName, string $alias): QueryBuilderAdapterInterface;

    public function flush(): void;

    public function delete(BaseDTOInterface $dto): void;

    public function persist(BaseDTOInterface $dto): void;
}
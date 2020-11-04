<?php

namespace COL\Library\Infrastructure\Database;

use COL\Library\Tools\DTO\BaseDTOInterface;

interface DatabaseAdapterInterface
{
    public function createQueryBuilder(string $dtoName): QueryBuilderAdapterInterface;

    public function flush(): void;

    public function delete(BaseDTOInterface $dto): void;

    public function persist(BaseDTOInterface $dto): void;
}
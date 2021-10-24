<?php

namespace COL\Library\Infrastructure\Adapter\Database;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use COL\Librairy\BaseContracts\Infrastructure\Adatper\Database\QueryBuilderAdapterInterface;

interface DatabaseAdapterInterface
{
    public function createQueryBuilder(string $dtoName, string $alias): QueryBuilderAdapterInterface;

    public function flush(): void;

    public function delete(DTOInterface $dto): void;

    public function persist(DTOInterface $dto): void;
}
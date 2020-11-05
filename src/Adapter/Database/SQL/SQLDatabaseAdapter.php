<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

final class SQLDatabaseAdapter implements DatabaseAdapterInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQueryBuilder(string $dtoName): SQLQueryBuilderAdapter
    {
        return new SQLQueryBuilderAdapter($this->entityManager->createQueryBuilder());
    }

    public function flush(): void
    {
        try {
            $this->entityManager->flush();
        } catch (ORMException $exception) {
            // TODO: Do something with that !
        }
    }

    public function delete(BaseDTOInterface $dto): void
    {
        try {
            $this->entityManager->remove($dto);
        } catch (ORMException $exception) {
            // TODO: Do something with that !
        }
    }

    public function persist(BaseDTOInterface $dto): void
    {
        try {
            $this->entityManager->persist($dto);
        } catch (ORMException $exception) {
            // TODO: Do something with that !
        }
    }
}
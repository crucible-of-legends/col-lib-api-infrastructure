<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

final class SQLDatabaseAdapter implements DatabaseAdapterInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQueryBuilder(string $dtoName, string $alias): SQLQueryBuilderAdapter
    {

        return new SQLQueryBuilderAdapter($this->entityManager->getRepository($dtoName)->createQueryBuilder($alias));
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
<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use COL\Librairy\BaseContracts\Domain\DataInteractor\DTOProvider\DTOProviderInterface;
use COL\Library\Infrastructure\Common\Repository\AbstractSQLBaseRepository;

abstract class AbstractSQLBaseDTOProvider implements DTOProviderInterface
{
    protected AbstractSQLBaseRepository $repository;

    /**
     * @return DTOInterface[]
     */
    public function getManyByCriteria(array $critieria = [], array $selects = [], array $orders = [], ?int $pageNumber = null, ?int $nbPerPage = null): array
    {
        return $this->getRepository()->findManyByCriteria($critieria, $selects, $orders, $pageNumber, $nbPerPage);
    }

    public function getOneByCId(string|int $id): ?DTOInterface
    {
        return $this->getRepository()->findOneByCriteria(['id' => $id]);
    }

    public function getOneByCriteria(array $critieria, array $selects = []): ?DTOInterface
    {
        return $this->getRepository()->findOneByCriteria($critieria, $selects);
    }

    public function countByCriteria(array $critieria = []): int
    {
        return $this->getRepository()->countByCriteria($critieria);
    }

    public function exists(array $critieria): bool
    {
        return $this->getRepository()->exists($critieria);
    }

    protected function getRepository(): AbstractSQLBaseRepository
    {
        return $this->repository;
    }
}

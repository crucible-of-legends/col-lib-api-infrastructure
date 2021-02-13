<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Library\Infrastructure\Common\Repository\AbstractDocumentBaseRepository;

abstract class AbstractDocumentBaseDTOProdiver
{
    protected AbstractDocumentBaseRepository $repository;

    /**
     * @return BaseDTOInterface[]
     */
    public function getManyByCriteria(array $critieria = [], array $selects = [], array $orders = [], ?int $pageNumber = null, ?int $nbPerPage = null): array
    {
        return $this->getRepository()->findManyByCriteria($critieria, $selects, $orders, $pageNumber, $nbPerPage);
    }

    /**
     * @return BaseDTOInterface|null
     */
    public function getOneByCriteria(array $critieria, array $selects = []): ?BaseDTOInterface
    {
        return $this->getRepository()->findOneByCriteria($critieria, $selects);
    }

    public function countByCriteria(array $critieria = []): int
    {
        return $this->getRepository()->countByCriteria($critieria);
    }

    public function exists(array $critieria): bool
    {
        //return $this->getRepository()->exists($critieria);
    }

    protected function getRepository(): AbstractDocumentBaseRepository
    {
        return $this->repository;
    }
}
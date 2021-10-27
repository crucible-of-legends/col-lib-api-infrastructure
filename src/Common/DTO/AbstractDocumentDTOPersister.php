<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTOPersister\DTOPersisterInterface;
use COL\Librairy\BaseContracts\Domain\Registry\DTOStatusRegistry;
use COL\Librairy\BaseContracts\Infrastructure\Clock\ClockInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDocumentDTOPersister implements DTOPersisterInterface
{
    public function __construct(private ObjectManager $objectManager, private ClockInterface $clock)
    {
    }

    protected function saveDto(AbstractDocumentBaseDTO $dto): AbstractDocumentBaseDTO
    {
        if (true === $dto->isNew()) {
            $this->objectManager->persist($dto);
        }

        $this->objectManager->flush();

        return $dto;
    }

    protected function softDelete(AbstractDocumentBaseDTO $dto): bool
    {
        if (DTOStatusRegistry::STATUS_DELETED === $dto->getStatus()) {
            return false;
        }

        $dto->setStatus(DTOStatusRegistry::STATUS_DELETED);
        $dto->setDeletedDate($this->clock->now());

        $this->objectManager->flush();

        return true;
    }
}

<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Library\Infrastructure\Clock\ClockInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDocumentDTOPersister
{
    protected ObjectManager $objectManager;
    protected ClockInterface $clock;

    public function __construct(ObjectManager $objectManager, ClockInterface $clock)
    {
        $this->objectManager = $objectManager;
        $this->clock = $clock;
    }

    protected function saveDto(AbstractDocumentBaseDTO $dto): AbstractDocumentBaseDTO
    {
        if (true === $dto->isNew()) {
            $this->objectManager->persist($dto);
        }

        $this->objectManager->flush();

        return $dto;
    }

    protected function softDelete(AbstractDocumentBaseDTO $dto): AbstractDocumentBaseDTO
    {
        $dto->setStatus(BaseDTOInterface::STATUS_DELETED);
        $dto->getDeletedDate($this->clock->now());

        $this->objectManager->flush();

        return $dto;
    }
}
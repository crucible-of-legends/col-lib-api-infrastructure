<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use DateTimeInterface;

abstract class AbstractDocumentBaseDTO implements DTOInterface
{
    protected ?string $id = null;
    protected string $status;
    protected ?DateTimeInterface $deletedDate;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return null === $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getDeletedDate(): ?DateTimeInterface
    {
        return $this->deletedDate;
    }

    public function setDeletedDate(?DateTimeInterface $deletedDate): void
    {
        $this->deletedDate = $deletedDate;
    }
}

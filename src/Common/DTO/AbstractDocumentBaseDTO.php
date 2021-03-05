<?php

namespace COL\Library\Infrastructure\Common\DTO;

use DateTimeInterface;

abstract class AbstractDocumentBaseDTO implements BaseDTOInterface
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
        return $this->id === null;
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
<?php

namespace COL\Library\Common\DTO;

use DateTimeInterface;

abstract class AbstractSQLBaseDTO implements BaseDTOInterface
{
    protected ?int $id;
    protected string $status;
    protected ?DateTimeInterface $deletedDate;

    public function getId(): ?int
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
<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Database\BaseDTOInterface;
use DateTimeInterface;

abstract class AbstractSQLBaseDTO implements BaseDTOInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    protected ?int $id;
    protected DateTimeInterface $createdDate;
    protected ?DateTimeInterface $updatedDate;
    protected string $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(DateTimeInterface $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getUpdatedDate(): ?DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?DateTimeInterface $updatedDate): void
    {
        $this->updatedDate = $updatedDate;
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
}
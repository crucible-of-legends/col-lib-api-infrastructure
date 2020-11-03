<?php

namespace COL\Library\Infrastructure\Adapter\Database\SQL;

use COL\Library\Infrastructure\Database\BaseDTOInterface;
use DateTimeInterface;

abstract class AbstractSQLBaseDTO implements BaseDTOInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    protected ?int $id;
    protected DateTimeInterface $createdAt;
    protected ?DateTimeInterface $updatedAt;
    protected string $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
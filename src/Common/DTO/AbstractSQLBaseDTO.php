<?php

namespace COL\Library\Common\DTO;

use DateTimeInterface;

abstract class AbstractSQLBaseDTO implements BaseDTOInterface
{
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
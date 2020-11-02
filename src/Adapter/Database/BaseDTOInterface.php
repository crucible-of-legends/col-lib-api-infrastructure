<?php

namespace COL\Library\Infrastructure\Database;

use \DateTimeInterface;

interface BaseDTOInterface
{
    public function getCreatedDate(): DateTimeInterface;
    public function setCreatedDate(DateTimeInterface $createdAt): void;

    public function getUpdatedDate(): ?DateTimeInterface;
    public function setUpdatedDate(?DateTimeInterface $updatedAt): void;

    public function getStatus(): string;
    public function setStatus(string $status): void;

    public function getDefaultStatus(): string;
    public function isNew(): bool;
}
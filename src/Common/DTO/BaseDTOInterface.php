<?php

namespace COL\Library\Common\DTO;

use \DateTimeInterface;

interface BaseDTOInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    public function getDeletedDate(): ?DateTimeInterface;
    public function setDeletedDate(?DateTimeInterface $updatedAt): void;

    public function getStatus(): string;
    public function setStatus(string $status): void;

    public function getDefaultStatus(): string;
    public function isNew(): bool;
}
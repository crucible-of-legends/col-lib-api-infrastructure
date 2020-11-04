<?php

namespace COL\Library\Common\DTO;

abstract class AbstractSQLBaseDTO implements BaseDTOInterface
{
    protected ?int $id;
    protected string $status;

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
}
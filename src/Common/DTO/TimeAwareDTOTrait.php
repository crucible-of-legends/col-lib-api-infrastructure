<?php

namespace COL\Library\Infrastructure\Common\DTO;

use DateTimeInterface;

trait TimeAwareDTOTrait
{
    protected DateTimeInterface $createdDate;
    protected ?DateTimeInterface $updatedDate;

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
}
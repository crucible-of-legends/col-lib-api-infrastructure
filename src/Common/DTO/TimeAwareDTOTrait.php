<?php

namespace COL\Library\Infrastructure\Common\DTO;

use DateTimeInterface;

trait TimeAwareDTOTrait
{
    public DateTimeInterface $createdDate;
    public ?DateTimeInterface $updatedDate;
}

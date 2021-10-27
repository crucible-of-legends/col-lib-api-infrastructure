<?php

namespace COL\Library\Infrastructure\Common\DTO;

use COL\Librairy\BaseContracts\Domain\DataInteractor\DTO\DTOInterface;
use DateTimeInterface;

abstract class AbstractSQLBaseDTO implements DTOInterface
{
    public ?int $id = null;
    public string $status;
    public ?DateTimeInterface $deletedDate;

    public function isNew(): bool
    {
        return null === $this->id;
    }
}

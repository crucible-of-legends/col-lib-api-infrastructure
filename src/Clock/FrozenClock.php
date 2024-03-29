<?php

namespace COL\Library\Infrastructure\Clock;

use COL\Librairy\BaseContracts\Infrastructure\Clock\ClockInterface;
use DateTimeImmutable;

final class FrozenClock implements ClockInterface
{
    public function __construct(private DateTimeImmutable $now)
    {
    }

    public function setTo(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}

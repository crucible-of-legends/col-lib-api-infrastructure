<?php

namespace COL\Library\Infrastructure\Clock;

use DateTimeImmutable;

interface ClockInterface
{
    public function now(): DateTimeImmutable;
}

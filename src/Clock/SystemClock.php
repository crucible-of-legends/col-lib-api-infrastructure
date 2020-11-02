<?php

namespace COL\Library\Infrastructure\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

class SystemClock implements ClockInterface
{
    private DateTimeZone $timezone;

    public function __construct(DateTimeZone $timezone = null)
    {
        $this->timezone = $timezone ?: new DateTimeZone(date_default_timezone_get());
    }

    /**
     * @throws Exception
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }
}

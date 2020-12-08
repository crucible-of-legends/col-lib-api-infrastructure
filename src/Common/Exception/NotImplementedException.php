<?php

namespace COL\Library\Infrastructure\Common\Exception;

use Throwable;

final class NotImplementedException extends \Exception
{
    public function __construct(string $className, string $functionName)
    {
        $message = "$className->$functionName is not implemented";

        parent::__construct($message, 501);
    }
}
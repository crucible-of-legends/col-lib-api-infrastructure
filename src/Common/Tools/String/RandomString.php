<?php

namespace COL\Library\Infrastructure\Common\Tools\String;

class RandomString
{
    public static function generate(?int $length = 10): string
    {
        return bin2hex(random_bytes($length));
    }
}
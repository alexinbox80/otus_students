<?php

namespace Support\Helper;

class AutoIncrementImitator
{
    private static int $currentId = 1;

    public static function nextId(): int
    {
        return self::$currentId++;
    }
}

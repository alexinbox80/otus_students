<?php

namespace App\Domain\Event;

class CreateUserEvent
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly string $activationCode
    ) {
    }
}

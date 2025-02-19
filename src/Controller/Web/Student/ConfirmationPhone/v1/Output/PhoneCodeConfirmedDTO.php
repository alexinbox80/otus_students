<?php

namespace App\Controller\Web\Student\ConfirmationPhone\v1\Output;

class PhoneCodeConfirmedDTO
{
        public function __construct(
            public readonly bool $success,
            public readonly string $message,
        ) {
        }
}

<?php

namespace App\Controller\Web\Student\ConfirmationEmail\v1\Output;

class EmailCodeConfirmedDTO
{
        public function __construct(
            public readonly bool $success,
            public readonly string $message,
        ) {
        }
}

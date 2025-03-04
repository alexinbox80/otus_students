<?php

namespace App\Controller\Web\Student\ConfirmationEmail\v1\Output;

use App\Controller\DTO\Interfaces\OutputEmailCodeConfirmedDTOInterface;

class EmailCodeConfirmedDTO implements OutputEmailCodeConfirmedDTOInterface
{
        public function __construct(
            public readonly bool $success,
            public readonly string $message,
        ) {
        }
}

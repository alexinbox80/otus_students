<?php

namespace App\Controller\Web\Teacher\ConfirmationPhone\v1\Output;

use App\Controller\DTO\Interfaces\OutputPhoneCodeConfirmedDTOInterface;

class PhoneCodeConfirmedDTO implements OutputPhoneCodeConfirmedDTOInterface
{
        public function __construct(
            public readonly bool $success,
            public readonly string $message,
        ) {
        }
}

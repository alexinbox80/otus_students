<?php

namespace App\Controller\Web\Sales\Customer\v1\Input;

class CustomerDTO
{
    public function __construct(
        public readonly string $studentId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email
    ) {
    }
}

<?php

namespace App\Controller\Web\Sales\Customer\v1\Output;

use App\Controller\DTO\Interfaces\OutputSalesIsCustomerDTOInterface;

class IsCustomerDTO implements OutputSalesIsCustomerDTOInterface
{
    public function __construct(
        public readonly bool $success,
        public readonly string $customerId
    ) {
    }
}
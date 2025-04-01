<?php

namespace App\Controller\Web\Sales\Subscribe\v1\Output;

use App\Controller\DTO\Interfaces\OutputSalesSubscribedDTOInterface;

class SubscribedDTO implements OutputSalesSubscribedDTOInterface
{
    public function __construct(
        public readonly bool $success,
        public readonly string $subscriptionId
    ) {
    }
}
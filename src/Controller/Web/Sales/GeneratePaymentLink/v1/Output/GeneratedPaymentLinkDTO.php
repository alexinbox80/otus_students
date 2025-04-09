<?php

namespace App\Controller\Web\Sales\GeneratePaymentLink\v1\Output;

use App\Controller\DTO\Interfaces\OutputSalesGeneratedPaymentLinkDTOInterface;

class GeneratedPaymentLinkDTO implements OutputSalesGeneratedPaymentLinkDTOInterface
{
    public function __construct(
        public readonly bool $success,
        public readonly string $paymentLink
    ) {
    }
}
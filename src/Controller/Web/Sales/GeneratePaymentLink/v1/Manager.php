<?php

namespace App\Controller\Web\Sales\GeneratePaymentLink\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\GeneratePaymentLink\v1\Output\GeneratedPaymentLinkDTO;

class Manager
{
    public function __construct(
        private readonly SalesInterface $sales)
    {
    }

    public function generatePaymentLink(string $subscriptionId): GeneratedPaymentLinkDTO
    {
        try {
            return new GeneratedPaymentLinkDTO(
                true,
                $this->sales->generatePaymentLink($subscriptionId)
            );
        } catch (\Exception $e) {
            // TODO Handle exceptions
            throw $e;
        }
    }
}

<?php

namespace App\Controller\Web\Sales\GeneratePaymentLink\v1;

use App\Controller\Web\Sales\GeneratePaymentLink\v1\Output\GeneratedPaymentLinkDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/generate-payment-link/{subscriptionId}',
        name: 'sales_generate_payment_link_v1_invoke',
        methods: ['GET']
    )]
    public function generatePaymentLink(string $subscriptionId): GeneratedPaymentLinkDTO
    {
        return $this->manager->generatePaymentLink($subscriptionId);
    }
}

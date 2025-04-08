<?php

namespace App\Controller\Web\Sales\Invoice\Expire\v1;

use App\Controller\Web\Sales\Invoice\Expire\v1\Input\InvoiceDTO;
use App\Controller\Web\Sales\Invoice\Expire\v1\Output\IsInvoiceDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/expire-invoice',
        name: 'sales_expire_invoice_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload]InvoiceDTO $invoiceDTO): IsInvoiceDTO
    {
        return $this->manager->invoice($invoiceDTO);
    }
}

<?php

namespace App\Controller\Web\Sales\Invoice\Expire\v1\Output;

use App\Controller\DTO\Interfaces\OutputSalesIsInvoiceDTOInterface;

class IsInvoiceDTO implements OutputSalesIsInvoiceDTOInterface
{
    public function __construct(
        public readonly bool $success,
        public readonly string $invoiceId
    ) {
    }
}

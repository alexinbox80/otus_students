<?php

namespace App\Controller\Web\Sales\Invoice\Expire\v1\Input;

class InvoiceDTO
{
    public function __construct(
        public readonly string $invoiceId
    ) {
    }
}

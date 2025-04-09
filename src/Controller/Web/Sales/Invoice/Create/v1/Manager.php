<?php

namespace App\Controller\Web\Sales\Invoice\Create\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\Invoice\Create\v1\Input\InvoiceDTO;
use App\Controller\Web\Sales\Invoice\Create\v1\Output\IsInvoiceDTO;

class Manager
{
    public function __construct(
        private SalesInterface $sales,
    ) {
    }

    public function invoice(InvoiceDTO $invoiceDTO): IsInvoiceDTO
    {
        try {
            $invoiceId = $this->sales->createInvoice(
                $invoiceDTO->subscriptionId,
                $invoiceDTO->dueDate,
            );
        } catch (\Exception $e) {
            // TODO Handle
            throw new $e;
        }

        return new IsInvoiceDTO(
            true,
            $invoiceId
        );
    }
}

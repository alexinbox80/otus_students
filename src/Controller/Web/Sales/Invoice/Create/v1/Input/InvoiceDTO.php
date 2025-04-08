<?php

namespace App\Controller\Web\Sales\Invoice\Create\v1\Input;

use DateTimeImmutable;

class InvoiceDTO
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly DateTimeImmutable $dueDate,
    ) {
    }
}

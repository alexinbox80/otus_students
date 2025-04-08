<?php

namespace App\Controller\Web\Sales\Product\Update\v1\Output;

use App\Controller\DTO\Interfaces\OutputSalesIsProductDTOInterface;

class IsProductDTO implements OutputSalesIsProductDTOInterface
{
    public function __construct(
        public readonly bool $success,
        public readonly string $productId
    ) {
    }
}

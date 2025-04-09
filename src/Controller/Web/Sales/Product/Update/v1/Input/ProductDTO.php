<?php

namespace App\Controller\Web\Sales\Product\Update\v1\Input;

class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $amount,
        public readonly string $currency
    ) {
    }
}

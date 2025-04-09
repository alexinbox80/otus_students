<?php

namespace App\Controller\Web\Sales\Product\Create\v1\Input;

class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $amount,
        public readonly string $currency
    ) {
    }
}

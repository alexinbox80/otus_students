<?php

namespace App\Controller\Web\Sales\Product\Update\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\Product\Update\v1\Input\ProductDTO;
use App\Controller\Web\Sales\Product\Update\v1\Output\IsProductDTO;

class Manager
{
    public function __construct(
        private SalesInterface $sales,
    ) {
    }

    public function product(string $productId, ProductDTO $productDTO): IsProductDTO
    {
        try {
            $productId = $this->sales->updateProduct(
                $productId,
                $productDTO->name,
                $productDTO->amount,
                $productDTO->currency
            );
        } catch (\Exception $e) {
            // TODO Handle
            throw new $e;
        }

        return new IsProductDTO(
            true,
            $productId
        );
    }
}

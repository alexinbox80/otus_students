<?php

namespace App\Controller\Web\Sales\Product\Delete\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\Product\Delete\v1\Output\DeletedProductDTO;

class Manager
{
    public function __construct(
        private SalesInterface $sales,
    ) {
    }

    public function product(string $prodId): DeletedProductDTO
    {
        try {
            $productId = $this->sales->deleteProduct(
                $prodId
            );
        } catch (\Exception $e) {
            // TODO Handle
            throw new $e;
        }

        return new DeletedProductDTO();
    }
}

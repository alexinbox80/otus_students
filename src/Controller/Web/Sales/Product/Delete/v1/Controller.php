<?php

namespace App\Controller\Web\Sales\Product\Delete\v1;

use App\Controller\Web\Sales\Product\Delete\v1\Output\DeletedProductDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/delete-product/{productId}',
        name: 'sales_delete_product_v1_invoke',
        //requirements: ['productId' => '\w+'],
        methods: ['DELETE']
    )]
    public function __invoke(string $productId): DeletedProductDTO
    {
        return $this->manager->product($productId);
    }
}

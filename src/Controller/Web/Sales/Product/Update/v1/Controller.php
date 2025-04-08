<?php

namespace App\Controller\Web\Sales\Product\Update\v1;

use App\Controller\Web\Sales\Product\Update\v1\Input\ProductDTO;
use App\Controller\Web\Sales\Product\Update\v1\Output\IsProductDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/update-product/{productId}',
        name: 'sales_update_product_v1_invoke',
        //requirements: ['productId' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(string $productId, #[MapRequestPayload] ProductDTO $productDTO): IsProductDTO
    {
        return $this->manager->product($productId, $productDTO);
    }
}

<?php

namespace App\Controller\Web\Sales\Product\Create\v1;

use App\Controller\Web\Sales\Product\Create\v1\Input\ProductDTO;
use App\Controller\Web\Sales\Product\Create\v1\Output\IsProductDTO;
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
        path: 'api/v1/create-product',
        name: 'sales_create_product_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] ProductDTO $productDTO): IsProductDTO
    {
        return $this->manager->product($productDTO);
    }
}

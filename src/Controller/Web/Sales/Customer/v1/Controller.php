<?php

namespace App\Controller\Web\Sales\Customer\v1;

use App\Controller\Web\Sales\Customer\v1\Input\CustomerDTO;
use App\Controller\Web\Sales\Customer\v1\Output\IsCustomerDTO;
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
        path: 'api/v1/create-customer',
        name: 'sales_create_customer_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CustomerDTO $customerDTO): IsCustomerDTO
    {
        return $this->manager->customer($customerDTO);
    }
}

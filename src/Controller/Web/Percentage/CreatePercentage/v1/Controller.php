<?php

namespace App\Controller\Web\Percentage\CreatePercentage\v1;

use App\Controller\Web\Percentage\CreatePercentage\v1\Input\CreatePercentageDTO;
use App\Controller\Web\Percentage\CreatePercentage\v1\Output\CreatedPercentageDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/percentage',
        name: 'web_create_percentage_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreatePercentageDTO $createPercentageDTO): CreatedPercentageDTO
    {
        return $this->manager->create($createPercentageDTO);
    }
}

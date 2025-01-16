<?php

namespace App\Controller\Web\Percentage\UpdatePercentage\v1;

use App\Controller\Web\Percentage\UpdatePercentage\v1\Input\UpdatePercentageDTO;
use App\Controller\Web\Percentage\UpdatePercentage\v1\Output\UpdatedPercentageDTO;
use App\Domain\Entity\Percentage;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/percentage/{id}',
        name: 'web_update_percentage_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Percentage $percentage,
        #[MapRequestPayload] UpdatePercentageDTO $updatePercentageDTO
    ): UpdatedPercentageDTO
    {
        return $this->manager->updatePercentage($percentage, $updatePercentageDTO);
    }
}

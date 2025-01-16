<?php

namespace App\Controller\Web\Percentage\DeletePercentage\v1;

use App\Controller\Web\Percentage\DeletePercentage\v1\Output\DeletedPercentageDTO;
use App\Domain\Entity\Percentage;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
        name: 'web_delete_percentage_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Percentage $percentage): DeletedPercentageDTO
    {
        return $this->manager->deletePercentage($percentage);
    }
}

<?php

namespace App\Controller\Web\User\GetUserById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\User\GetUserById\v1\Output\GotUserByIdDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(
        path: 'api/v1/get-user-by-id/{id}',
        name: 'web_get_user_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function __invoke(
        int $id
    ): GotUserByIdDTO|EmptyDTO
    {
        return $this->manager->find($id);
    }
}

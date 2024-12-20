<?php

namespace App\Controller;

use App\Domain\Entity\User;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(): Response
    {
//        $user = $this->userService->create('J.R.R. Tolkien 1', 'password');
//
//        return $this->json($user->toArray());

//        $user = $this->userService->create('Jack London 1 ', 'password');
//        $this->userService->removeById($user->getId());
//        $usersByLogin = $this->userService->findUsersByLogin($user->getLogin());
//
//        return $this->json(['users' => array_map(static fn (User $user) => $user->toArray(), $usersByLogin)]);

        $this->userService->removeById(1);
        $userById = $this->userService->find(1);

        return $this->json(['user' => $userById->toArray()]);
    }
}

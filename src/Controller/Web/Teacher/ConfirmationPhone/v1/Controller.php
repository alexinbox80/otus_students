<?php

namespace App\Controller\Web\Teacher\ConfirmationPhone\v1;

use App\Controller\Web\Teacher\ConfirmationPhone\v1\Input\PhoneConfirmationCodeDTO;
use App\Controller\Web\Teacher\ConfirmationPhone\v1\Output\PhoneCodeConfirmedDTO;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller  extends AbstractController
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route(
        path: 'api/v1/teacher/phone-confirmation',
        name: 'web_phone_confirmation_teacher_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] PhoneConfirmationCodeDTO $confirmationCodeDTO): PhoneCodeConfirmedDTO
    {
        return $this->manager->confirmation($confirmationCodeDTO, $this->getUser());
    }
}

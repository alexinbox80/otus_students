<?php

namespace App\Controller\Web\Teacher\ConfirmationEmail\v1;

use App\Controller\Web\Teacher\ConfirmationEmail\v1\Input\EmailConfirmationCodeDTO;
use App\Controller\Web\Teacher\ConfirmationEmail\v1\Output\EmailCodeConfirmedDTO;
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
        path: 'api/v1/teacher/email-confirmation',
        name: 'web_email_confirmation_teacher_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] EmailConfirmationCodeDTO $confirmationCodeDTO): EmailCodeConfirmedDTO
    {
        return $this->manager->confirmation($confirmationCodeDTO, $this->getUser());
    }
}

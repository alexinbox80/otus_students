<?php

namespace App\Controller\Web\Student\ConfirmationEmail\v1;

use App\Controller\Web\Student\ConfirmationEmail\v1\Input\EmailConfirmationCodeDTO;
use App\Controller\Web\Student\ConfirmationEmail\v1\Output\EmailCodeConfirmedDTO;
use App\Domain\Service\StudentService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

class Manager
{
    public function __construct(
        private readonly StudentService $studentService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function confirmation(EmailConfirmationCodeDTO $emailConfirmationCodeDTO, UserInterface $user): EmailCodeConfirmedDTO
    {
        $result = $this->studentService->confirmationEmail($emailConfirmationCodeDTO, $user->getUserIdentifier());

        if (!$result) {
            $success = false;
            $message = 'Email confirmation code is mismatched!';
        } else {
            $success = true;
            $message = 'Email confirmation code is correct!';
        }

        return new EmailCodeConfirmedDTO(
            $success,
            $message
        );
    }
}

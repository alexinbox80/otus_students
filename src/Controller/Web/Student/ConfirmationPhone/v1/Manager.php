<?php

namespace App\Controller\Web\Student\ConfirmationPhone\v1;

use App\Controller\Web\Student\ConfirmationPhone\v1\Input\PhoneConfirmationCodeDTO;
use App\Controller\Web\Student\ConfirmationPhone\v1\Output\PhoneCodeConfirmedDTO;
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
    public function confirmation(PhoneConfirmationCodeDTO $phoneConfirmationCodeDTO, UserInterface $user): PhoneCodeConfirmedDTO
    {
        $result = $this->studentService->confirmationPhone($phoneConfirmationCodeDTO, $user->getUserIdentifier());

        if (!$result) {
            $success = false;
            $message = 'Phone confirmation code is mismatched!';
        } else {
            $success = true;
            $message = 'Phone confirmation code is correct!';
        }

        return new PhoneCodeConfirmedDTO(
            $success,
            $message
        );
    }
}

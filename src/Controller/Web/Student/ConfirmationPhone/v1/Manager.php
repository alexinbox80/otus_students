<?php

namespace App\Controller\Web\Student\ConfirmationPhone\v1;

use App\Controller\Web\Student\ConfirmationPhone\v1\Input\PhoneConfirmationCodeDTO;
use App\Controller\Web\Student\ConfirmationPhone\v1\Output\PhoneCodeConfirmedDTO;
use App\Domain\Model\CreatePhoneConfirmationCodeModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreatePhoneConfirmationCodeModel> */
        private readonly ModelFactory $modelFactory,
        private readonly StudentService $studentService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function confirmation(PhoneConfirmationCodeDTO $phoneConfirmationCodeDTO, UserInterface $user): PhoneCodeConfirmedDTO
    {
        $emailConfirmationCodeModel = $this->modelFactory->makeModel(
            CreatePhoneConfirmationCodeModel::class,
            $phoneConfirmationCodeDTO->phoneCode
        );

        $result = $this->studentService->confirmationPhone($emailConfirmationCodeModel, $user->getUserIdentifier());

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

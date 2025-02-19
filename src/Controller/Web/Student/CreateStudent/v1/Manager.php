<?php

namespace App\Controller\Web\Student\CreateStudent\v1;

use App\Controller\Web\Student\CreateStudent\v1\Input\CreateStudentDTO;
use App\Controller\Web\Student\CreateStudent\v1\Output\CreatedStudentDTO;
use App\Domain\Event\CreateStudentEvent;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateStudentModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly StudentService $studentService,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(CreateStudentDTO $createStudentDTO): CreatedStudentDTO
    {
        $emailCode = rand(100000, 999999);
        $phoneCode = rand(100000, 999999);

        $createStudentModel = $this->modelFactory->makeModel(
            CreateStudentModel::class,
            $createStudentDTO->userId,
            $createStudentDTO->firstName,
            $createStudentDTO->lastName,
            $createStudentDTO->middleName,
            $createStudentDTO->email,
            $createStudentDTO->phone,
            $emailCode,
            $phoneCode
        );

        $student = $this->studentService->create($createStudentModel);

        $event = new CreateStudentEvent(
            $student->getId(),
            $student->getUserId(),
            $emailCode,
            $phoneCode
        );
        $event = $this->eventDispatcher->dispatch($event);

        return new CreatedStudentDTO(
            $student->getId(),
            $student->getUserId(),
            $student->getFirstName(),
            $student->getLastName(),
            $student->getMiddleName(),
            $student->getEmail(),
            $student->getPhone(),
            $student->getCreatedAt()->format('Y-m-d H:i:s'),
            $student->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}

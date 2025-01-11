<?php

namespace App\Controller\Web\Student\CreateStudent\v1;

use App\Controller\Web\Student\CreateStudent\v1\Input\CreateStudentDTO;
use App\Controller\Web\Student\CreateStudent\v1\Output\CreatedStudentDTO;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateStudentModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly StudentService $studentService
    ) {
    }

    public function create(CreateStudentDTO $createStudentDTO): CreatedStudentDTO
    {
        $createStudentModel = $this->modelFactory->makeModel(
            CreateStudentModel::class,
            $createStudentDTO->firstName,
            $createStudentDTO->lastName,
            $createStudentDTO->middleName,
            $createStudentDTO->email,
            $createStudentDTO->phone
        );

        $student = $this->studentService->create($createStudentModel);

        return new CreatedStudentDTO(
            $student->getId(),
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

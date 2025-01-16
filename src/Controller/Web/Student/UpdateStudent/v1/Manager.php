<?php

namespace App\Controller\Web\Student\UpdateStudent\v1;

use App\Controller\Web\Student\UpdateStudent\v1\Input\UpdateStudentDTO;
use App\Controller\Web\Student\UpdateStudent\v1\Output\UpdatedStudentDTO;
use App\Domain\Entity\Student;
use App\Domain\Model\UpdateStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateStudentModel> */
        private readonly ModelFactory $modelFactory,
        private readonly StudentService $studentService
    ) {
    }

    public function updateStudent(Student $student, UpdateStudentDTO $updateStudentDTO): UpdatedStudentDTO
    {
        $updateStudentModel = $this->modelFactory->makeModel(
            UpdateStudentModel::class,
            $updateStudentDTO->firstName,
            $updateStudentDTO->lastName,
            $updateStudentDTO->middleName,
            $updateStudentDTO->email,
            $updateStudentDTO->phone
        );

        $student = $this->studentService->update($student, $updateStudentModel);

        return new UpdatedStudentDTO(
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

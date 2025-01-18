<?php

namespace App\Controller\Web\Teacher\UpdateTeacher\v1;

use App\Controller\Web\Teacher\UpdateTeacher\v1\Input\UpdateTeacherDTO;
use App\Controller\Web\Teacher\UpdateTeacher\v1\Output\UpdatedTeacherDTO;
use App\Domain\Entity\Teacher;
use App\Domain\Model\UpdateTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateTeacherModel> */
        private readonly ModelFactory $modelFactory,
        private readonly TeacherService $teacherService
    ) {
    }

    public function updateTeacher(Teacher $teacher, UpdateTeacherDTO $updateTeacherDTO): UpdatedTeacherDTO
    {
        $updateTeacherModel = $this->modelFactory->makeModel(
            UpdateTeacherModel::class,
            $updateTeacherDTO->firstName,
            $updateTeacherDTO->lastName,
            $updateTeacherDTO->middleName,
            $updateTeacherDTO->email,
            $updateTeacherDTO->phone
        );

        $teacher = $this->teacherService->update($teacher, $updateTeacherModel);

        return new UpdatedTeacherDTO(
            $teacher->getId(),
            $teacher->getFirstName(),
            $teacher->getLastName(),
            $teacher->getMiddleName(),
            $teacher->getEmail(),
            $teacher->getPhone(),
            $teacher->getCreatedAt()->format('Y-m-d H:i:s'),
            $teacher->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}

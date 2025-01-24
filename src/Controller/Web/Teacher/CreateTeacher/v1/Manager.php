<?php

namespace App\Controller\Web\Teacher\CreateTeacher\v1;

use App\Controller\Web\Teacher\CreateTeacher\v1\Input\CreateTeacherDTO;
use App\Controller\Web\Teacher\CreateTeacher\v1\Output\CreatedTeacherDTO;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateTeacherModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly TeacherService $teacherService
    ) {
    }

    public function create(CreateTeacherDTO $createTeacherDTO): CreatedTeacherDTO
    {
        $createTeacherModel = $this->modelFactory->makeModel(
            CreateTeacherModel::class,
            $createTeacherDTO->firstName,
            $createTeacherDTO->lastName,
            $createTeacherDTO->middleName,
            $createTeacherDTO->email,
            $createTeacherDTO->phone
        );

        $teacher = $this->teacherService->create($createTeacherModel);

        return new CreatedTeacherDTO(
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

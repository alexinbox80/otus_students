<?php

namespace App\Controller\Web\Teacher\CreateTeacher\v1;

use App\Controller\Web\Teacher\CreateTeacher\v1\Input\CreateTeacherDTO;
use App\Controller\Web\Teacher\CreateTeacher\v1\Output\CreatedTeacherDTO;
use App\Domain\Event\CreateTeacherEvent;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateTeacherModel> */
        private readonly ModelFactory  $modelFactory,
        private readonly TeacherService $teacherService,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(CreateTeacherDTO $createTeacherDTO): CreatedTeacherDTO
    {
        $emailCode = rand(100000, 999999);
        $phoneCode = rand(100000, 999999);

        $createTeacherModel = $this->modelFactory->makeModel(
            CreateTeacherModel::class,
            $createTeacherDTO->userId,
            $createTeacherDTO->firstName,
            $createTeacherDTO->lastName,
            $createTeacherDTO->middleName,
            $createTeacherDTO->email,
            $createTeacherDTO->phone,
            $emailCode,
            $phoneCode
        );

        $teacher = $this->teacherService->create($createTeacherModel);

        $event = new CreateTeacherEvent(
            $teacher->getId(),
            $teacher->getUserId(),
            $emailCode,
            $phoneCode
        );
        $event = $this->eventDispatcher->dispatch($event);

        return new CreatedTeacherDTO(
            $teacher->getId(),
            $teacher->getUserId(),
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

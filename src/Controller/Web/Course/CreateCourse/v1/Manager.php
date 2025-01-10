<?php

namespace App\Controller\Web\Course\CreateCourse\v1;

use App\Controller\Web\Course\CreateCourse\v1\Input\CreateCourseDTO;
use App\Controller\Web\Course\CreateCourse\v1\Output\CreatedCourseDTO;
use App\Domain\Model\CreateCourseModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\CourseService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateCourseModel> */
        private readonly ModelFactory $modelFactory,
        private readonly CourseService $courseService,
    ) {
    }

    public function create(CreateCourseDTO $createCourseDTO): CreatedCourseDTO
    {
        $createCourseModel = $this->modelFactory->makeModel(
            CreateCourseModel::class,
            $createCourseDTO->name,
            $createCourseDTO->description
        );

        $course = $this->courseService->create($createCourseModel);

        return new CreatedCourseDTO(
            $course->getId(),
            $course->getName(),
            $course->getDescription(),
            $course->getCreatedAt()->format('Y-m-d H:i:s'),
            $course->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}

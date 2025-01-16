<?php

namespace App\Controller\Web\Course\UpdateCourse\v1;

use App\Controller\Web\Course\UpdateCourse\v1\Input\UpdateCourseDTO;
use App\Controller\Web\Course\UpdateCourse\v1\Output\UpdatedCourseDTO;
use App\Domain\Entity\Course;
use App\Domain\Model\UpdateCourseModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\CourseService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateCourseModel> */
        private readonly ModelFactory $modelFactory,
        private readonly CourseService $courseService
    ) {
    }

    public function updateCourse(Course $course, UpdateCourseDTO $updateCourseDTO): UpdatedCourseDTO
    {
        $updateCourseModel = $this->modelFactory->makeModel(
            UpdateCourseModel::class,
            $updateCourseDTO->name,
            $updateCourseDTO->description
        );

        $course = $this->courseService->update($course, $updateCourseModel);

        return new UpdatedCourseDTO(
            $course->getId(),
            $course->getName(),
            $course->getDescription(),
            $course->getCreatedAt()->format('Y-m-d H:i:s'),
            $course->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}

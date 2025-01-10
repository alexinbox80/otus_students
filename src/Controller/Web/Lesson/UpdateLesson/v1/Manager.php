<?php

namespace App\Controller\Web\Lesson\UpdateLesson\v1;

use App\Controller\Web\Lesson\UpdateLesson\v1\Input\UpdateLessonDTO;
use App\Controller\Web\Lesson\UpdateLesson\v1\Output\UpdatedLessonDTO;
use App\Domain\Entity\Lesson;
use App\Domain\Model\UpdateLessonModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateLessonModel> */
        private readonly ModelFactory $modelFactory,
        private readonly LessonService $lessonService
    ) {
    }

    public function updateLesson(Lesson $lesson, UpdateLessonDTO $updateLessonDTO): UpdatedLessonDTO
    {
        $updateLessonModel = $this->modelFactory->makeModel(
            UpdateLessonModel::class,
            $updateLessonDTO->name,
            $updateLessonDTO->description
        );

        $lesson = $this->lessonService->update($lesson, $updateLessonModel);

        return new UpdatedLessonDTO(
            $lesson->getId(),
            $lesson->getName(),
            $lesson->getDescription(),
            $lesson->getCreatedAt()->format('Y-m-d H:i:s'),
            $lesson->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}

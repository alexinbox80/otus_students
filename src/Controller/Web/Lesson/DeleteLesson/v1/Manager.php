<?php

namespace App\Controller\Web\Lesson\DeleteLesson\v1;

use App\Controller\Web\Lesson\DeleteLesson\v1\Output\DeletedLessonDTO;
use App\Domain\Entity\Lesson;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {
    }

    public function deleteLesson(Lesson $lesson): DeletedLessonDTO
    {
        $this->lessonService->removeLesson($lesson);
        return new DeletedLessonDTO();
    }
}

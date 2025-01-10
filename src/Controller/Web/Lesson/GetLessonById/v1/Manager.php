<?php

namespace App\Controller\Web\Lesson\GetLessonById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Lesson\GetLessonById\v1\Output\GotLessonByIdDTO;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(private readonly LessonService $lessonService)
    {
    }

    /**
     * @param int $lessonId
     * @return GotLessonByIdDTO|EmptyDTO
     */
    public function find(int $lessonId): GotLessonByIdDTO|EmptyDTO
    {
        $lesson = $this->lessonService->find($lessonId);

        if (!is_null($lesson)) {
            return new GotLessonByIdDTO(
                $lesson->getId(),
                $lesson->getName(),
                $lesson->getDescription(),
                $lesson->getCreatedAt()->format('Y-m-d H:i:s'),
                $lesson->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}

<?php

namespace App\Controller\Web\Lesson\GetLessons\v1;

use App\Domain\Entity\Lesson;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(private readonly LessonService $lessonService)
    {
    }

    /**
     * @return Lesson[]
     */
    public function getLessons(?int $page, ?int $perPage): array
    {
        return $this->lessonService->getLessons($page, $perPage);
    }
}

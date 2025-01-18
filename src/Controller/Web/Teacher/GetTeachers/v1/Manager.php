<?php

namespace App\Controller\Web\Teacher\GetTeachers\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    /**
     * @return Teacher[]
     */
    public function getTeachers(?int $page, ?int $perPage): array
    {
        return $this->teacherService->getTeachers($page, $perPage);
    }
}

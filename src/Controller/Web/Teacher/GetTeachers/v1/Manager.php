<?php

namespace App\Controller\Web\Teacher\GetTeachers\v1;

use App\Domain\Model\TeacherModel;
use App\Domain\Service\TeacherService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    /**
     * @return TeacherModel[]
     * @throws InvalidArgumentException
     */
    public function getTeachers(?int $page, ?int $perPage): array
    {
        return [
            'teachers' => $this->teacherService->getTeachersPaginated($page, $perPage)
        ];
    }
}

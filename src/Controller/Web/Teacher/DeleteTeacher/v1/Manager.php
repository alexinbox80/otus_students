<?php

namespace App\Controller\Web\Teacher\DeleteTeacher\v1;

use App\Controller\Web\Teacher\DeleteTeacher\v1\Output\DeletedTeacherDTO;
use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;
use Psr\Cache\InvalidArgumentException;

class Manager
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function deleteTeacher(Teacher $teacher): DeletedTeacherDTO
    {
        $this->teacherService->removeTeacher($teacher);
        return new DeletedTeacherDTO();
    }
}

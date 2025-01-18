<?php

namespace App\Controller\Web\Teacher\DeleteTeacher\v1;

use App\Controller\Web\Teacher\DeleteTeacher\v1\Output\DeletedTeacherDTO;
use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(
        private readonly TeacherService $teacherService
    ) {
    }

    public function deleteTeacher(Teacher $teacher): DeletedTeacherDTO
    {
        $this->teacherService->removeTeacher($teacher);
        return new DeletedTeacherDTO();
    }
}

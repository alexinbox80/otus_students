<?php

namespace App\Controller\Web\Teacher\GetTeacherById\v1;

use App\Controller\DTO\EmptyDTO;
use App\Controller\Web\Teacher\GetTeacherById\v1\Output\GotTeacherByIdDTO;
use App\Domain\Service\TeacherService;

class Manager
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    /**
     * @param int $teacherId
     * @return GotTeacherByIdDTO|EmptyDTO
     */
    public function find(int $teacherId): GotTeacherByIdDTO|EmptyDTO
    {
        $teacher = $this->teacherService->find($teacherId);

        if (!is_null($teacher)) {
            return new GotTeacherByIdDTO(
                $teacher->getId(),
                $teacher->getUserId(),
                $teacher->getLastName(),
                $teacher->getFirstName(),
                $teacher->getMiddleName(),
                $teacher->getPhone(),
                $teacher->getEmail(),
                $teacher->getCreatedAt()->format('Y-m-d H:i:s'),
                $teacher->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        } else {
            return new EmptyDTO();
        }
    }
}

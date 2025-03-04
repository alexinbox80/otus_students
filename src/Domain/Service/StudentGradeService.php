<?php

namespace App\Domain\Service;

use App\Domain\Bus\StudentsGradeBusInterface;
use App\Domain\DTO\StudentsGradeDTO;
use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Repository\StudentGradeRepositoryInterface;
use DateTime;

class StudentGradeService
{
    public function __construct(
        private readonly StudentGradeRepositoryInterface $studentGradeRepository,
        private readonly StudentsGradeBusInterface $studentsGradeBus
    ) {
    }

    /**
     * @param int $studentId
     * @param int|null $entityId
     * @param string $typeStudentsGrade
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @return void
     */
    public function getTotalGradeAsync(int $studentId, string $typeStudentsGrade, ?int $entityId = null,  ?DateTime $startDate = null, ?DateTime $endDate = null): void
    {
        $this->studentsGradeBus->studentsGrade(
            new StudentsGradeDTO (
                $studentId,
                $typeStudentsGrade,
                $entityId,
                $startDate,
                $endDate,
            )
        );
    }

    /**
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLesson(Lesson $lesson, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForLesson($lesson, $student);
    }

    /**
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForSkill($skill, $student);
    }

    /**
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeForCourse($course, $student);
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRange(DateTime $startDate, DateTime $endDate, Student $student): float
    {
        return $this->studentGradeRepository->getTotalGradeInTimeRange($startDate, $endDate, $student);
    }
}

<?php

namespace App\Domain\Service;

use App\Domain\Bus\StudentsGradeBusInterface;
use App\Domain\DTO\StudentsGradeDTO;
use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Repository\StudentGradeRepositoryInterface;
use App\Domain\ValueObject\StudentGradeEnum;
use DateTime;

class StudentGradeService
{
    public function __construct(
        private readonly StudentGradeRepositoryInterface $studentGradeRepository,
        private readonly StudentsGradeBusInterface $studentsGradeBus,
        private readonly StudentService $studentService,
        private readonly CompletedTaskService $completedTaskService
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

    /**
     * @return array
     */
    public function getStudentGradeForCourse(): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $totalGrade[] = [
                    'id' => $student->getId(),
                    'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                    'courseName' => $completedTask->getTask()->getLesson()->getCourse()->getName(),
                    'totalGrade' => $this->getTotalGradeForCourse($completedTask->getTask()->getLesson()->getCourse(), $student)
                ];
            }
        }

        return $totalGrade;
    }

    /**
     * @return void
     */
    public function getStudentGradeForCourseAsync(): void
    {
        $students = $this->studentService->findAll();

        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $this->getTotalGradeAsync(
                    $student->getId(),
                    StudentGradeEnum::GET_STUDENT_GRADE_FOR_COURSE->value,
                    $completedTask->getTask()->getLesson()->getCourse()->getId(),
                );
            }
        }
    }

    /**
     * @return array
     */
    public function getStudentGradeForLesson(): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $totalGrade[] = [
                    'id' => $student->getId(),
                    'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                    'lessonName' => $completedTask->getTask()->getLesson()->getName(),
                    'totalGrade' => $this->getTotalGradeForLesson($completedTask->getTask()->getLesson(), $student)
                ];
            }
        }

        return $totalGrade;
    }

    /**
     * @return void
     */
    public function getStudentGradeForLessonAsync(): void
    {
        $students = $this->studentService->findAll();

        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $this->getTotalGradeAsync(
                    $student->getId(),
                    StudentGradeEnum::GET_STUDENT_GRADE_FOR_LESSON->value,
                    $completedTask->getTask()->getLesson()->getId(),
                );
            }
        }
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return array
     */
    public function getStudentGradeForLessonInTimeRange(DateTime $startDate, DateTime $endDate): array
    {
        $students = $this->studentService->findAll();

        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $totalGrade[] = [
                    'id' => $student->getId(),
                    'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                    'lessonName' => $completedTask->getTask()->getLesson()->getName(),
                    'totalGrade' => $this->getTotalGradeInTimeRange($startDate, $endDate, $student)
                ];
            }
        }

        return $totalGrade;
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return void
     */
    public function getStudentGradeForLessonInTimeRangeAsync(DateTime $startDate, DateTime $endDate): void
    {
        $students = $this->studentService->findAll();

        foreach ($students as $student) {
            $completedTasks = $this->completedTaskService->findByStudent($student);
            foreach ($completedTasks as $completedTask) {
                $this->getTotalGradeAsync(
                    $student->getId(),
                    StudentGradeEnum::GET_STUDENT_GRADE_IN_TIME_RANGE->value,
                    $completedTask->getId(),
                    $startDate,
                    $endDate
                );
            }
        }
    }

    /**
     * @return array
     */
    public function getStudentGradeForSkill(): array
    {
        $students = $this->studentService->findAll();
        $totalGrade = [];
        foreach ($students as $student) {
            $completedTasks = $student->getCompletedTasks();
            foreach ($completedTasks as $completedTask) {
                $percentages = $completedTask->getTask()->getPercentages();
                foreach ($percentages as $percentage) {
                    $totalGrade[] = [
                        'id' => $student->getId(),
                        'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                        'skillName' => $percentage->getSkill()->getName(),
                        'totalGrade' => $this->getTotalGradeForSkill($percentage->getSkill(), $student)
                    ];
                }
            }
        }

        return $totalGrade;
    }

    /**
     * @return void
     */
    public function getStudentGradeForSkillAsync(): void
    {
        $students = $this->studentService->findAll();
        foreach ($students as $student) {
            $completedTasks = $student->getCompletedTasks();
            foreach ($completedTasks as $completedTask) {
                $percentages = $completedTask->getTask()->getPercentages();
                foreach ($percentages as $percentage) {
                    $this->getTotalGradeAsync(
                        $student->getId(),
                        StudentGradeEnum::GET_STUDENT_GRADE_FOR_SKILL->value,
                        $percentage->getSkill()->getId()
                    );
                }
            }
        }
    }
}

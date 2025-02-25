<?php

namespace App\Controller\Amqp\StudentsGrade;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\StudentsGrade\Input\Message;
use App\Domain\Service\CourseService;
use App\Domain\Service\LessonService;
use App\Domain\Service\SkillService;
use App\Domain\Service\StudentGradeService;
use App\Domain\Service\StudentService;
use App\Domain\ValueObject\StudentGradeEnum;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly LessonService $lessonService,
        private readonly SkillService $skillService,
        private readonly CourseService $courseService,
        private readonly StudentGradeService $studentGradeService,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        $totalGrade = [];

        if ($message->typeStudentsGrade === StudentGradeEnum::GET_STUDENT_GRADE_FOR_LESSON->value ) {
            $student = $this->studentService->find($message->studentId);

            if ($student === null) {
                return $this->reject(sprintf('Student ID %s was not found! ', $message->studentId));
            }

            $lesson = $this->lessonService->find($message->entityId);

            if ($lesson === null) {
                return $this->reject(sprintf('Lesson ID %s was not found! ', $message->entityId));
            }

            $totalGrade[] = [
                'id' => $student->getId(),
                'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                'lessonName' => $lesson->getName(),
                'totalGrade' => $this->studentGradeService->getTotalGradeForLesson($lesson, $student)
            ];
        }

        if ($message->typeStudentsGrade === StudentGradeEnum::GET_STUDENT_GRADE_FOR_SKILL->value ) {
            $student = $this->studentService->find($message->studentId);

            if ($student === null) {
                return $this->reject(sprintf('Student ID %s was not found! ', $message->studentId));
            }

            $skill = $this->skillService->find($message->entityId);

            if ($skill === null) {
                return $this->reject(sprintf('Skill ID %s was not found! ', $message->entityId));
            }

            $totalGrade[] = [
                'id' => $student->getId(),
                'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                'skillName' => $skill->name,
                //'totalGrade' => $this->studentGradeService->getTotalGradeForSkill($skill, $student)
            ];
        }

        if ($message->typeStudentsGrade === StudentGradeEnum::GET_STUDENT_GRADE_FOR_COURSE->value ) {
            $student = $this->studentService->find($message->studentId);

            if ($student === null) {
                return $this->reject(sprintf('Student ID %s was not found! ', $message->studentId));
            }

            $course = $this->courseService->find($message->entityId);

            if ($course === null) {
                return $this->reject(sprintf('Course ID %s was not found! ', $message->entityId));
            }

            $totalGrade[] = [
                'id' => $student->getId(),
                'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                'courseName' => $course->getName(),
                'totalGrade' => $this->studentGradeService->getTotalGradeForCourse($course, $student)
            ];
        }

        if ($message->typeStudentsGrade === StudentGradeEnum::GET_STUDENT_GRADE_IN_TIME_RANGE->value ) {
            $student = $this->studentService->find($message->studentId);

            if ($student === null) {
                return $this->reject(sprintf('Student ID %s was not found! ', $message->studentId));
            }

            $lesson = $this->lessonService->find($message->entityId);

            if ($lesson === null) {
                return $this->reject(sprintf('Lesson ID %s was not found! ', $message->entityId));
            }

            $totalGrade[] = [
                'id' => $student->getId(),
                'userName' => $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName(),
                'lessonName' => $lesson->getName(),
                'totalGrade' => $this->studentGradeService->getTotalGradeInTimeRange($message->startDate, $message->endDate, $student)
            ];
        }

        if (count($totalGrade) > 0)
            dump($totalGrade);

        return self::MSG_ACK;
    }
}

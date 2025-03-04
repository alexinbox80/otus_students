<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Percentage;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use DateTime;
use App\Domain\Entity\CompletedTask;
use Doctrine\Common\Collections\Criteria;

class StudentGradeRepository extends AbstractRepository
{
    /**
     * Получаем суммарный балл за все задания урока для конкретного студента
     *
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLessonWithCriteria(Lesson $lesson, Student $student): float
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('student', $student));
        //$criteria->andWhere(Criteria::expr()?->contains('task', $lesson->getTasks()[0]));
        foreach ($lesson->getTasks() as $task) {
            $criteria->andWhere(Criteria::expr()?->eq('task', $task));
        }
        $repository = $this->entityManager->getRepository(CompletedTask::class);
        $completedTasks = $repository->matching($criteria)->toArray();

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            $totalGrade += $completedTask->getGrade();
        }

        return number_format($totalGrade, 2);
    }

    /**
     * Получаем суммарный балл по всем выполненным заданиям студента, для указанного навыка
     *
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float
    {
        $completedTasks = $this->entityManager->getRepository(CompletedTask::class)->findBy(['student' => $student]);

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            /** @var Percentage $percentage */
            foreach ($completedTask->getTask()->getPercentages() as $percentage) {
                if ($percentage->getSkill() === $skill) {
                    $totalGrade += 0.01 * $percentage->getPercent() * $completedTask->getGrade();
                }
            }
        }

        return number_format($totalGrade, 2);
    }

    /**
     * Получаем суммарный балл студента по всем выполненным заданиям указанного курса
     *
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float
    {
        $completedTasks = $this->entityManager->getRepository(CompletedTask::class)->findBy(['student' => $student]);

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            if ($completedTask->getTask()->getLesson()->getCourse() === $course) {
                $totalGrade += $completedTask->getGrade();
            }
        }

        return number_format($totalGrade, 2);
    }

    /**
     * Получаем суммарный балл студента по всем выполненным заданиям за указанный интервал времени
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRangeWithCriteria(DateTime $startDate, DateTime $endDate, Student $student): float
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()?->eq('student', $student));
        $criteria->andWhere(Criteria::expr()?->gte('finishedAt', $startDate));
        $criteria->andWhere(Criteria::expr()?->lte('finishedAt', $endDate));

        $repository = $this->entityManager->getRepository(CompletedTask::class);
        $completedTasks = $repository->matching($criteria)->toArray();

        $totalGrade = 0;
        /** @var CompletedTask $completedTask */
        foreach ($completedTasks as $completedTask) {
            $totalGrade += $completedTask->getGrade();
        }

        return number_format($totalGrade, 2);
    }
}

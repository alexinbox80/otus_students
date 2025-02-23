<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use DateTime;

interface StudentGradeRepositoryInterface
{
    /**
     * @param Lesson $lesson
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForLesson(Lesson $lesson, Student $student): float;

    /**
     * @param Skill $skill
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForSkill(Skill $skill, Student $student): float;

    /**
     * @param Course $course
     * @param Student $student
     * @return float
     */
    public function getTotalGradeForCourse(Course $course, Student $student): float;

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Student $student
     * @return float
     */
    public function getTotalGradeInTimeRange(DateTime $startDate, DateTime $endDate, Student $student): float;
}

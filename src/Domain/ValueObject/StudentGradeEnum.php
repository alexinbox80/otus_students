<?php

namespace App\Domain\ValueObject;

enum StudentGradeEnum: string
{
    case GET_STUDENT_GRADE_FOR_LESSON = 'getStudentsGradeForLesson';
    case GET_STUDENT_GRADE_FOR_SKILL = 'getStudentsGradeForSkill';
    case GET_STUDENT_GRADE_FOR_COURSE = 'getStudentsGradeForCourse';
    case GET_STUDENT_GRADE_IN_TIME_RANGE = 'getStudentsGradeInTimeRange';
}

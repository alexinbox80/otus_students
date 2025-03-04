<?php

namespace App\Domain\ValueObject;

enum RedisCacheTagEnum: string
{
    case CACHE_TAG_SKILLS = 'skills';
    case CACHE_TAG_COMPLETED_TASKS = 'completed_tasks';
    case CACHE_TAG_STUDENTS = 'students';
    case CACHE_TAG_TEACHERS = 'teachers';
    case CACHE_TAG_GET_TOTAL_GRADE_FOR_LESSON = 'getTotalGradeForLesson';
    case CACHE_TAG_GET_TOTAL_GRADE_FOR_SKILL = 'getTotalGradeForSkill';
    case CACHE_TAG_GET_TOTAL_GRADE_FOR_COURSE = 'getTotalGradeForCourse';
    case CACHE_TAG_GET_TOTAL_GRADE_IN_TIME_RANGE = 'getTotalGradeInTimeRange';
}

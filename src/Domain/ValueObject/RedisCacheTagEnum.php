<?php

namespace App\Domain\ValueObject;

enum RedisCacheTagEnum: string
{
    case CACHE_TAG_SKILLS = 'skills';
    case CACHE_TAG_COMPLETED_TASKS = 'completed_tasks';

    case CACHE_TAG_STUDENTS = 'students';
}

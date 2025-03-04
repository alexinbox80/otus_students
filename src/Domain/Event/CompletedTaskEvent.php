<?php

namespace App\Domain\Event;

use App\Domain\Entity\Task;
use App\Domain\Model\CreateCompletedTaskModel;

class CompletedTaskEvent
{
    public function __construct(
        public readonly CreateCompletedTaskModel $createCompletedTaskModel,
        public readonly Task $task
    ) {
    }
}

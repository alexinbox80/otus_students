<?php

namespace App\Domain\Model;

use DateTime;

class CompletedTaskModel
{
    public function __construct(
        public readonly int $id,
        public readonly int $studentId,
        public readonly int $taskId,
        public readonly DateTime $finishedAt,
        public readonly ?string $description,
        public readonly int $grade,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getFinishedAt(): DateTime
    {
        return $this->finishedAt;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getGrade(): int
    {
        return $this->grade;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}

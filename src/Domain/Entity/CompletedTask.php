<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Table(name: 'completed_task')]
#[ORM\Entity]
#[ORM\Index(name: 'completed_task__student_id__ind', columns: ['student_id'])]
#[ORM\Index(name: 'completed_task__task_id__ind', columns: ['task_id'])]
#[ORM\Index(name: 'completed_task__grade__ind', columns: ['grade'])]
#[ORM\UniqueConstraint(name: 'completed_task__student__task__uniq', fields: ['student', 'task'])]
#[ORM\HasLifecycleCallbacks]
class CompletedTask implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'integer', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'finished_at', type: 'datetime', nullable: true)]
    private ?DateTime $finishedAt = null;

    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private string $description;

    #[ORM\Column(name: 'grade', type: 'smallint', nullable: true)]
    #[Assert\Range(min: 1, max: 10)]
    private ?int $grade = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'completedTasks')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'completedTasks')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?DateTime $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(?int $grade): void
    {
        $this->grade = $grade;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }
}
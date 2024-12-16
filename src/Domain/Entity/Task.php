<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'task')]
#[ORM\Entity]
#[ORM\Index(name: 'task__lesson_id__ind', columns: ['lesson_id'])]
#[ORM\UniqueConstraint(name: 'task__name__lesson__uniq', fields: ['name', 'lesson'])]
#[ORM\HasLifecycleCallbacks]
class Task implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'integer', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Lesson::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: 'lesson_id', referencedColumnName: 'id')]
    private ?Lesson $lesson = null;

    #[ORM\OneToMany(targetEntity: Percentage::class, mappedBy: 'task')]
    private Collection $percentages;

    #[ORM\OneToMany(targetEntity: CompletedTask::class, mappedBy: 'task')]
    private Collection $completedTasks;

    public function __construct()
    {
        $this->percentages = new ArrayCollection();
        $this->completedTasks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function getPercentages(): Collection
    {
        return $this->percentages;
    }

    public function setPercentages(Collection $percentages): void
    {
        $this->percentages = $percentages;
    }

    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
    }

    public function setCompletedTasks(Collection $completedTasks): void
    {
        $this->completedTasks = $completedTasks;
    }
}

<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'lesson')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'lesson__course_id__ind', columns: ['course_id'])]
#[ORM\UniqueConstraint(name: 'lesson__name__course__uniq', fields: ['name', 'course'])]
class Lesson implements EntityInterface, HasMetaTimestampsInterface
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

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private ?Course $course = null;

    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'lesson', cascade: ['remove'])]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Course|null
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course|null $course
     * @return void
     */
    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Collection $tasks
     * @return void
     */
    public function setTasks(Collection $tasks): void
    {
        $this->tasks = $tasks;
    }

    /**
     * @param Task $task
     * @return Lesson
     */
    public function addTask(Task $task): Lesson
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return Lesson
     */
    public function removeTask(Task $task): Lesson
    {
        $this->tasks->removeElement($task);
        return $this;
    }

    /**
     * @return Lesson
     */
    public function removeCourse(): Lesson
    {
        $this->course = null;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'course' => $this->getCourse()->toArray(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'tasks' => array_map(
                static fn(Task $task) => [
                    'id' => $task->getId(),
                    'name' => $task->getName(),
                    'description' => $task->getDescription(),
                ],
                $this->getTasks()->toArray()
            )
        ];
    }
}

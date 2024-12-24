<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Lesson|null
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * @param Lesson|null $lesson
     * @return void
     */
    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * @return Collection
     */
    public function getPercentages(): Collection
    {
        return $this->percentages;
    }

    /**
     * @param Collection $percentages
     * @return void
     */
    public function setPercentages(Collection $percentages): void
    {
        $this->percentages = $percentages;
    }

    /**
     * @return Collection]
     */
    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
    }

    /**
     * @param Collection $completedTasks
     * @return void
     */
    public function setCompletedTasks(Collection $completedTasks): void
    {
        $this->completedTasks = $completedTasks;
    }

    /**
     * @param Percentage $percentage
     * @return Task
     * @throws Exception
     */
    public function addPercentage(Percentage $percentage): Task
    {
        if (!$this->percentages->contains($percentage)) {
            $percents = 0;
            /** @var Percentage $p */
            foreach ($this->percentages as $p) {
                $percents += $p->getPercent();
            }

            if ($percents + $percentage->getPercent() > 100) {
                throw new Exception(sprintf(
                    'Доля добавляемого навыка не может превышать %s%%',
                    100 - $percents
                ));
            }

            $this->percentages->add($percentage);
        }

        return $this;
    }

    /**
     * @param Percentage $percentage
     * @return Task
     */
    public function removePercentage(Percentage $percentage): Task
    {
        $this->percentages->removeElement($percentage);
        return $this;
    }

    /**
     * @param CompletedTask $completedTask
     * @return Task
     */
    public function addCompletedTask(CompletedTask $completedTask): Task
    {
        if (!$this->completedTasks->contains($completedTask)) {
            $this->completedTasks->add($completedTask);
        }

        return $this;
    }

    /**
     * @param CompletedTask $completedTask
     * @return Task
     */
    public function removeCompletedTask(CompletedTask $completedTask): Task
    {
        $this->completedTasks->removeElement($completedTask);
        return $this;
    }

    /**
     * @return Task
     */
    public function removeLesson(): Task
    {
        $this->lesson = null;
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
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'lesson' => $this->getLesson()->toArray(),
            'skills' => array_map(
                static fn(Percentage $percentage) => [
                    'id' => $percentage->getSkill()->getId(),
                    'name' => $percentage->getSkill()->getName(),
                    'description' => $percentage->getSkill()->getDescription(),
                    'percent' => $percentage->getPercent(),
                    'createdAt' => $percentage->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updatedAt' => $percentage->getUpdatedAt()->format('Y-m-d H:i:s'),
                ],
                $this->getPercentages()->toArray()
            )
        ];
    }
}

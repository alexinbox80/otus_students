<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;

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
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Lesson::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: 'lesson_id', referencedColumnName: 'id')]
    private ?Lesson $lesson = null;

    #[ORM\OneToMany(targetEntity: Percentage::class, mappedBy: 'task')]
    private Collection $percentages;

    #[ORM\OneToMany(targetEntity: CompletedTask::class, mappedBy: 'task')]
    private Collection $completedTasks;

    public function __construct(string $name, ?string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->percentages = new ArrayCollection();
        $this->completedTasks = new ArrayCollection();
    }

    public function getId(): int
    {
        WebmozartAssert::notNull($this->id, sprintf('Id of Entity %s is null.', get_class($this)));

        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
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

    /**
     * @return Collection<int,CompletedTask>
     */
    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
    }

    public function setCompletedTasks(Collection $completedTasks): void
    {
        $this->completedTasks = $completedTasks;
    }

    public function addPercentage(Percentage $percentage): self
    {
        if (!$this->percentages->contains($percentage)) {
            $percents = 0;
            /** @var Percentage $p */
            foreach ($this->percentages as $p) {
                $percents += $p->getPercent();
            }

//            if ($percents + $percentage->getPercent() > 100) {
//                throw new Exception(sprintf(
//                    'Доля добавляемого навыка не может превышать %s%%',
//                    100 - $percents
//                ));
//            }

            WebmozartAssert::greaterThan(
                $percents + $percentage->getPercent(),
                100,
                sprintf('Доля добавляемого навыка не может превышать %s%%', 100 - $percents)
            );

            $this->percentages->add($percentage);
        }

        return $this;
    }

    public function removePercentage(Percentage $percentage): self
    {
        $this->percentages->removeElement($percentage);
        return $this;
    }

    public function addCompletedTask(CompletedTask $completedTask): self
    {
        if (!$this->completedTasks->contains($completedTask)) {
            $this->completedTasks->add($completedTask);
        }

        return $this;
    }

    public function removeCompletedTask(CompletedTask $completedTask): self
    {
        $this->completedTasks->removeElement($completedTask);
        return $this;
    }

    public function removeLesson(): self
    {
        $this->lesson = null;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'skills' => array_map(
                static fn(Percentage $percentage) => $percentage->toArray(),
                $this->getPercentages()->toArray()
            )
        ];
    }
}

<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'percentage')]
#[ORM\Entity]
#[ORM\Index(name: 'percentage__task_id__ind', columns: ['task_id'])]
#[ORM\Index(name: 'percentage__skill_id__ind', columns: ['skill_id'])]
#[ORM\UniqueConstraint(name: 'percentage__task__skill__uniq', fields: ['task', 'skill'])]
#[ORM\HasLifecycleCallbacks]
class Percentage implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'integer', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'percent', type: 'float', nullable: false)]
    #[Assert\Range(min: 0, max: 100)]
    private float $percent;

    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'percentages')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;

    #[ORM\ManyToOne(targetEntity: Skill::class, inversedBy: 'percentages')]
    #[ORM\JoinColumn(name: 'skill_id', referencedColumnName: 'id')]
    private Skill $skill;

    /**
     * @throws Exception
     */
    public function getId(): int
    {
        if (is_null($this->id)) {
            throw new Exception(sprintf('Id of Entity %s is null.', get_class($this)));
        }

        return $this->id;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): void
    {
        $this->percent = $percent;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): void
    {
        $this->skill = $skill;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'percent' => $this->getPercent(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}

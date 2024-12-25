<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'course')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'course__name__uniq', fields: ['name'])]
#[ORM\HasLifecycleCallbacks]
class Course implements EntityInterface, HasMetaTimestampsInterface
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

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'course')]
    private Collection $subscriptions;

    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'course')]
    private Collection $lessons;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }

    public function getId(): int
    {
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function setSubscriptions(Collection $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function setLessons(Collection $lessons): void
    {
        $this->lessons = $lessons;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        $this->subscriptions->removeElement($subscription);
        return $this;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): Course
    {
        $this->lessons->removeElement($lesson);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'lessons' => array_map(
                static fn(Lesson $lesson) => [
                    'id' => $lesson->getId(),
                    'name' =>  $lesson->getName(),
                    'description' => $lesson->getDescription(),
                    'createdAt' => $lesson->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updatedAt' => $lesson->getUpdatedAt()->format('Y-m-d H:i:s'),
                ],
                $this->getLessons()->toArray()
            )
        ];
    }
}

<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'student')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'student__last_name__first_name__middle_name__ind', columns: ['last_name', 'first_name', 'middle_name'])]
#[ORM\Index(name: 'student__first_name__last_name__middle_name__ind', columns: ['first_name', 'last_name', 'middle_name'])]
#[ORM\Index(name: 'student__phone__ind', columns: ['phone'])]
#[ORM\Index(name: 'student__email__ind', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'student__user_id__uniq', fields: ['user'])]
class Student extends Person implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'student')]
    private Collection $subscriptions;

    #[ORM\OneToMany(targetEntity: CompletedTask::class, mappedBy: 'student')]
    private Collection $completedTasks;

    #[ORM\OneToMany(targetEntity: UnlockedAchievement::class, mappedBy: 'student')]
    private Collection $unlockedAchievements;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->completedTasks = new ArrayCollection();
        $this->unlockedAchievements = new ArrayCollection();
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
     * @return Collection
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    /**
     * @param Subscription $subscription
     * @return self
     */
    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
        }

        return $this;
    }

    /**
     * @param Subscription $subscription
     * @return self
     */
    public function removeSubscription(Subscription $subscription): self
    {
        $this->subscriptions->removeElement($subscription);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
    }

    /**
     * @param CompletedTask $completedTask
     * @return self
     */
    public function addCompletedTask(CompletedTask $completedTask): self
    {
        if (!$this->completedTasks->contains($completedTask)) {
            $this->completedTasks->add($completedTask);
        }

        return $this;
    }

    /**
     * @param CompletedTask $completedTask
     * @return self
     */
    public function removeCompletedTask(CompletedTask $completedTask): self
    {
        $this->completedTasks->removeElement($completedTask);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUnlockedAchievements(): Collection
    {
        return $this->unlockedAchievements;
    }

    /**
     * @param UnlockedAchievement $unlockedAchievement
     * @return self
     */
    public function addUnlockedAchievement(UnlockedAchievement $unlockedAchievement): self
    {
        if (!$this->unlockedAchievements->contains($unlockedAchievement)) {
            $this->unlockedAchievements->add($unlockedAchievement);
        }

        return $this;
    }

    /**
     * @param UnlockedAchievement $unlockedAchievement
     * @return self
     */
    public function removeUnlockedAchievement(UnlockedAchievement $unlockedAchievement): self
    {
        $this->unlockedAchievements->removeElement($unlockedAchievement);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'lastName' => $this->getLastName(),
            'firstName' => $this->getFirstName(),
            'middleName' => $this->getMiddleName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'user' => $this->user->toArray(),
            'courses' => array_map(
                static fn(Subscription $subscription) => [
                    'id' => $subscription->getCourse()->getId(),
                    'name' => $subscription->getCourse()->getName(),
                    'description' => $subscription->getCourse()->getDescription()
                ],
                $this->getSubscriptions()->toArray()
            ),
            'unlockedAchievements' => array_map(
                static fn(UnlockedAchievement $unlockedAchievement) => [
                    'id' => $unlockedAchievement->getAchievement()->getId(),
                    'name' => $unlockedAchievement->getAchievement()->getName(),
                    'description' => $unlockedAchievement->getAchievement()->getDescription(),
                    'createdAt' => $unlockedAchievement->getCreatedAt(),
                ],
                $this->getUnlockedAchievements()->toArray()
            )
        ];
    }
}

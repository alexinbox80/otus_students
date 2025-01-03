<?php

namespace App\Domain\Entity;

use Webmozart\Assert\Assert as WebmozartAssert;
use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

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

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'student')]
    private User $user;

    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'student')]
    private Collection $subscriptions;

    #[ORM\OneToMany(targetEntity: CompletedTask::class, mappedBy: 'student')]
    private Collection $completedTasks;

    #[ORM\OneToMany(targetEntity: UnlockedAchievement::class, mappedBy: 'student')]
    private Collection $unlockedAchievements;

    public function __construct(
        string $firstName,
        string $lastName,
        ?string $middleName,
        ?string $phone,
        ?string $email
    )
    {
        parent::__construct($firstName, $lastName, $middleName, $phone, $email);

        $this->subscriptions = new ArrayCollection();
        $this->completedTasks = new ArrayCollection();
        $this->unlockedAchievements = new ArrayCollection();
    }

    public function getId(): int
    {
        WebmozartAssert::notNull($this->id, sprintf('Id of Entity %s is null.', get_class($this)));

        return $this->id;
    }

    /**
     * @return Collection<int,Subscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
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

    /**
     * @return Collection<int,CompletedTask>
     */
    public function getCompletedTasks(): Collection
    {
        return $this->completedTasks;
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

    /**
     * @return Collection<int,UnlockedAchievement>
     */
    public function getUnlockedAchievements(): Collection
    {
        return $this->unlockedAchievements;
    }

    public function addUnlockedAchievement(UnlockedAchievement $unlockedAchievement): self
    {
        if (!$this->unlockedAchievements->contains($unlockedAchievement)) {
            $this->unlockedAchievements->add($unlockedAchievement);
        }

        return $this;
    }

    public function removeUnlockedAchievement(UnlockedAchievement $unlockedAchievement): self
    {
        $this->unlockedAchievements->removeElement($unlockedAchievement);
        return $this;
    }

    public function toArray(): array
    {
        return
            array_merge(
                parent::toArray(),
                [
                    'id' => $this->id,
                    'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
                    'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
                    'courses' => array_map(
                        static fn(Subscription $subscription) => $subscription->toArray(),
                        $this->getSubscriptions()->toArray()
                    ),
                    'completedTasks' => array_map(
                        static fn(CompletedTask $completedTask) => $completedTask->toArray(),
                        $this->getCompletedTasks()->toArray()
                    ),
                    'unlockedAchievements' => array_map(
                        static fn(UnlockedAchievement $unlockedAchievement) => $unlockedAchievement->toArray(),
                        $this->getUnlockedAchievements()->toArray()
                    )
                ]
            );
    }
}

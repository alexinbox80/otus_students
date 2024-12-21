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

//    #[ORM\Column(name: 'last_name', type: 'string', length: 64, nullable: false)]
//    private string $lastName;
//
//    #[ORM\Column(name: 'first_name', type: 'string', length: 64, nullable: false)]
//    private string $firstName;
//
//    #[ORM\Column(name: 'middle_name', type: 'string', length: 64, nullable: false)]
//    private string $middleName;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->getId(),
            'login' => $this->user->getLogin(),
            'lastName' => $this->getLastName(),
            'firstName' => $this->getFirstName(),
            'middleName' => $this->getMiddleName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
}

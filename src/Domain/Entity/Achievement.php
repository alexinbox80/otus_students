<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'achievement')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'achievement__name__uniq', fields: ['name'])]
#[ORM\HasLifecycleCallbacks]
class Achievement implements EntityInterface, HasMetaTimestampsInterface
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

    #[ORM\OneToMany(targetEntity: UnlockedAchievement::class, mappedBy: 'achievement')]
    private Collection $unlockedAchievements;

    public function __construct()
    {
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

    public function getUnlockedAchievements(): Collection
    {
        return $this->unlockedAchievements;
    }

    public function setUnlockedAchievements(Collection $unlockedAchievements): void
    {
        $this->unlockedAchievements = $unlockedAchievements;
    }
}
<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

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

    /**
     * @return Collection<array-key,UnlockedAchievement>
     */
    public function getUnlockedAchievements(): Collection
    {
        return $this->unlockedAchievements;
    }

    public function setUnlockedAchievements(Collection $unlockedAchievements): void
    {
        $this->unlockedAchievements = $unlockedAchievements;
    }

    public function addUnlockedAchievement(UnlockedAchievement $unlockedAchievement): Achievement
    {
        if (!$this->unlockedAchievements->contains($unlockedAchievement)) {
            $this->unlockedAchievements->add($unlockedAchievement);
        }

        return $this;
    }

    public function removeUnlockedAchievement(UnlockedAchievement $unlockedAchievement): Achievement
    {
        $this->unlockedAchievements->removeElement($unlockedAchievement);
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
            'unlockedByStudents' => array_map(
                static fn(UnlockedAchievement $unlockedAchievement) => [
                    'id' => $unlockedAchievement->getStudent()->getId(),
                    'lastName' => $unlockedAchievement->getStudent()->getLastName(),
                    'firstName' => $unlockedAchievement->getStudent()->getFirstName(),
                    'middleName' => $unlockedAchievement->getStudent()->getMiddleName(),
                ],
                $this->getUnlockedAchievements()->toArray()
            )
        ];
    }
}

<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'skill__name__uniq', fields: ['name'])]
#[ORM\HasLifecycleCallbacks]
class Skill implements EntityInterface, HasMetaTimestampsInterface
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

    #[ORM\OneToMany(targetEntity: Percentage::class, mappedBy: 'skill')]
    private Collection $percentages;

    public function __construct()
    {
        $this->percentages = new ArrayCollection();
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
     * @param Percentage $percentage
     * @return Skill
     */
    public function addPercentage(Percentage $percentage): Skill
    {
        if (!$this->percentages->contains($percentage)) {
            $this->percentages->add($percentage);
        }

        return $this;
    }

    /**
     * @param Percentage $percentage
     * @return Skill
     */
    public function removePercentage(Percentage $percentage): Skill
    {
        $this->percentages->removeElement($percentage);
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
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
    }
}

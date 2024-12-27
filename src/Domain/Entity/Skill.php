<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

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
     * @return Collection<array-key,Percentage>
     */
    public function getPercentages(): Collection
    {
        return $this->percentages;
    }

    public function setPercentages(Collection $percentages): void
    {
        $this->percentages = $percentages;
    }

    public function addPercentage(Percentage $percentage): self
    {
        if (!$this->percentages->contains($percentage)) {
            $this->percentages->add($percentage);
        }

        return $this;
    }

    public function removePercentage(Percentage $percentage): self
    {
        $this->percentages->removeElement($percentage);
        return $this;
    }

    /**
     * @throws Exception
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

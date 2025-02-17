<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Interfaces\HasMetaTimestampsInterface;
use App\Domain\Entity\Interfaces\SoftDeletableInterface;
use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'email_notification')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class EmailNotification implements EntityInterface, HasMetaTimestampsInterface, SoftDeletableInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique:true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $email;

    #[ORM\Column(type: 'string', length: 512, nullable: false)]
    private string $text;

    #[ORM\Column(type: 'string', length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 512, nullable: true)]
    private ?string $entityName = null;

    public function __construct(
        string $email,
        string $text,
        ?string $description = null,
        ?string $entityName = null
    )
    {
        $this->email = $email;
        $this->text = $text;
        $this->description = $description;
        $this->entityName = $entityName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEntityName(): ?string
    {
        return $this->entityName;
    }
}

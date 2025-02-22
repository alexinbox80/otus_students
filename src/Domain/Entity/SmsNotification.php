<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Interfaces\HasMetaTimestampsInterface;
use App\Domain\Entity\Interfaces\SoftDeletableInterface;
use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sms_notification')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class SmsNotification implements EntityInterface, HasMetaTimestampsInterface, SoftDeletableInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique:true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'user_id', type: 'integer', nullable: true)]
    private ?int $userId = null;

    #[ORM\Column(type: 'string', length: 11, nullable: false)]
    private string $phone;

    #[ORM\Column(type: 'string', length: 512, nullable: false)]
    private string $text;

    #[ORM\Column(type: 'string', length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 512, nullable: true)]
    private ?string $entityName = null;

    public function __construct(
        string $userId,
        string $phone,
        string $text,
        ?string $description = null,
        ?string $entityName = null
    )
    {
        $this->userId = $userId;
        $this->phone = $phone;
        $this->text = $text;
        $this->description = $description;
        $this->entityName = $entityName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function getPhone(): string
    {
        return $this->phone;
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

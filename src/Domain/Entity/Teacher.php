<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Interfaces\HasMetaTimestampsInterface;
use App\Domain\Entity\Interfaces\SoftDeletableInterface;
use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;

#[ORM\Table(name: 'teacher')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'teacher__last_name__first_name__middle_name__ind', columns: ['last_name', 'first_name', 'middle_name'])]
#[ORM\Index(name: 'teacher__first_name__last_name__middle_name__ind', columns: ['first_name', 'last_name', 'middle_name'])]
#[ORM\Index(name: 'teacher__phone__ind', columns: ['phone'])]
#[ORM\Index(name: 'teacher__email__ind', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'teacher__user_id__uniq', fields: ['user'], options: ['where' => '(deleted_at IS NULL)'])]
#[ApiResource]
class Teacher extends Person implements EntityInterface, HasMetaTimestampsInterface, SoftDeletableInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'teacher')]
    private User $user;

    public function __construct(
        string $firstName,
        string $lastName,
        ?string $middleName,
        ?string $email,
        ?string $phone
    )
    {
        parent::__construct($firstName, $lastName, $middleName, $email, $phone);
    }

    public function getId(): int
    {
        WebmozartAssert::notNull($this->id, sprintf('Id of Entity %s is null.', get_class($this)));

        return $this->id;
    }

    public function changeFields(
        string $firstName,
        string $lastName,
        ?string $middleName,
        ?string $email,
        ?string $phone
    ): void
    {
        $this->changeName($firstName, $lastName, $middleName);
        $this->changeContacts($email, $phone);
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
                ]
            );
    }
}

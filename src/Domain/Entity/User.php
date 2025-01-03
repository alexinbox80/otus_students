<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'user__login__uniq', fields: ['login'])]
class User implements EntityInterface, HasMetaTimestampsInterface, SoftDeletableInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'login', type: 'string', length: 32, unique: true, nullable: false)]
    private string $login;

    #[ORM\Column(name: 'password', type: 'string', length: 64, nullable: false)]
    private string $password;

    #[ORM\Column(name: 'roles', type: 'json')]
    private array $roles = [];

    #[ORM\Column(name: 'isActive', type: 'boolean', options: ['default' => true])]
    private bool $isActive;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $avatarLink = null;

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'user')]
    private Student $student;

    public function __construct(
        string $login,
        string $password,
        bool $isActive = true,
        ?string $avatarLink = null
    )
    {
        $this->login = $login;
        $this->password = $password;
        $this->isActive = $isActive;
        $this->avatarLink = $avatarLink;
    }

    public function getId(): int
    {
        WebmozartAssert::notNull($this->id, sprintf('Id of Entity %s is null.', get_class($this)));

        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getAvatarLink(): ?string
    {
        return $this->avatarLink;
    }

    public function setAvatarLink(?string $avatarLink): void
    {
        $this->avatarLink = $avatarLink;
    }

    public function changeFields(
        string $login,
        string $password,
        ?bool $isActive,
        ?array $roles = [],
        ?string $avatarLink = null
    ): void
    {
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setRoles($roles);
        $this->setIsActive($isActive);
        $this->setAvatarLink($avatarLink);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'login' => $this->login,
            'isActive' => $this->isActive,
            'avatar' => $this->avatarLink,
            'roles' => $this->roles,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'student' => empty($this->student) ? null : $this->student->toArray(),
        ];
    }
}

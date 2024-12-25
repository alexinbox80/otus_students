<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'user')]
    private Student $student;

    public function getId(): int
    {
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'isActive' => $this->isActive,
            'roles' => $this->roles,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'student' => [
                'id' => $this->student->getId(),
                'lastName' => $this->student->getLastName(),
                'firstName' => $this->student->getFirstName(),
                'middleName' => $this->student->getMiddleName(),
                'email' => $this->student->getEmail(),
                'phone' => $this->student->getPhone(),
                'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
                'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            ],
        ];
    }
}

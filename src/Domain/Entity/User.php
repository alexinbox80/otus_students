<?php

namespace App\Domain\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Domain\ApiPlatform\DTO\Input\CreateUserDTO;
use App\Domain\ApiPlatform\DTO\Output\CreatedUserDTO;
use App\Domain\ApiPlatform\State\UserDeleteProcessor;
use App\Domain\ApiPlatform\State\UserPatchProcessor;
use App\Domain\ApiPlatform\State\UserPostProcessor;
use App\Domain\ApiPlatform\State\UserProviderDecorator;
use App\Domain\Entity\Interfaces\EntityInterface;
use App\Domain\Entity\Interfaces\HasMetaTimestampsInterface;
use App\Domain\Entity\Interfaces\SoftDeletableInterface;
use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use App\Domain\ValueObject\RoleEnum;
use Symfony\Component\Serializer\Attribute\Ignore;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'user__login__uniq', fields: ['login'], options: ['where' => '(deleted_at IS NULL)'])]
#[ApiResource(operations: [
    new Get(output: CreatedUserDTO::class, provider: UserProviderDecorator::class),
    new Post(input: CreateUserDTO::class, output: CreatedUserDTO::class, processor: UserPostProcessor::class),
    new Patch(input: CreateUserDTO::class, output: CreatedUserDTO::class, processor: UserPatchProcessor::class),
    new Delete(processor: UserDeleteProcessor::class)
])]
#[ApiFilter(SearchFilter::class, properties: ['login' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['login'])]
class User implements
    EntityInterface,
    HasMetaTimestampsInterface,
    SoftDeletableInterface,
    UserInterface,
    PasswordAuthenticatedUserInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'login', type: 'string', length: 32, unique: true, nullable: false)]
    private string $login;

    #[Ignore]
    #[ORM\Column(name: 'password', type: 'string', length: 64, nullable: false)]
    private string $password;

    #[ORM\Column(type: 'json', length: 1024, nullable: false)]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 32, unique: true, nullable: true)]
    private ?string $refreshToken = null;

    #[ORM\Column(name: 'isActive', type: 'boolean', options: ['default' => true])]
    private bool $isActive;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $avatarLink = null;

    #[ORM\OneToOne(targetEntity: Student::class, mappedBy: 'user')]
    private Student $student;

    #[ORM\OneToOne(targetEntity: Teacher::class, mappedBy: 'user')]
    private Teacher $teacher;

    #[ORM\OneToOne(targetEntity: Manager::class, mappedBy: 'user')]
    private Manager $manager;

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

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = RoleEnum::ROLE_USER->value;

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
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

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function changeFields(
        string $login,
        string $password,
        ?bool $isActive,
        ?string $avatarLink = null,
        ?array $roles = []
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
            'login' => $this->getLogin(),
            'isActive' => $this->isActive(),
            'avatar' => $this->getAvatarLink(),
            'roles' => $this->getRoles(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'student' => empty($this->student) ? null : $this->student->toArray(),
            'teacher' => empty($this->teacher) ? null : $this->teacher->toArray(),
            'manager' => empty($this->manager) ? null : $this->manager->toArray(),
        ];
    }
}

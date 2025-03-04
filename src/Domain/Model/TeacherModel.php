<?php

namespace App\Domain\Model;

use DateTime;

class TeacherModel
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $middleName,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}

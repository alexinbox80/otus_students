<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;

#[ORM\MappedSuperclass]
class Person
{
    #[ORM\Column(name: 'last_name', type: 'string', length: 64, nullable: false)]
    private string $lastName;

    #[ORM\Column(name: 'first_name', type: 'string', length: 64, nullable: false)]
    private string $firstName;

    #[ORM\Column(name: 'middle_name', type: 'string', length: 64, nullable: true)]
    private ?string $middleName;

    #[ORM\Column(name: 'phone', type: 'string', length: 16, nullable: true)]
    private ?string $phone;

    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: true)]
    private ?string $email;

    public function __construct(
        string $lastName,
        string $firstName,
        ?string $middleName,
        ?string $email,
        ?string $phone
    )
    {
        self::lastNameValidate($lastName);
        self::firstNameValidate($firstName);
        self::middleNameValidate($middleName);
        self::emailValidate($email);
        self::phoneValidate($phone);

        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->phone = $phone;
    }

    private function lastNameValidate(string $lastName): void
    {
        WebmozartAssert::stringNotEmpty($lastName, 'Last name should not be empty. Got: %s');
        //Assert::regexp()
        WebmozartAssert::alpha($lastName, 'Last name should be in alphabet. Got: %s');
        WebmozartAssert::lengthBetween($lastName, 2, 64, 'The last name must be a string valid length of 2-64 letters. Got: %s');
    }

    private function firstNameValidate(string $firstName): void
    {
        WebmozartAssert::stringNotEmpty($firstName, 'First name should not be empty. Got: %s');
        //Assert::regexp()
        WebmozartAssert::alpha($firstName, 'First name should be in alphabet. Got: %s');
        WebmozartAssert::lengthBetween($firstName, 2, 64, 'The first name must be a string valid length of 2-64 letters. Got: %s');
    }

    private function middleNameValidate(?string $middleName = null): void
    {
        WebmozartAssert::nullOrString($middleName, 'The middle name must be a string valid length of 2-64 letters or null. Got: %s');
        if (!is_null($middleName))
        {
            //Assert::regexp()
            WebmozartAssert::alpha($middleName, 'Middle name should be in alphabet. Got: %s');
            WebmozartAssert::lengthBetween($middleName, 2, 64, 'The middle name must be a string valid length of 2-64 letters. Got: %s');
        }
    }

    private function emailValidate(?string $email = null): void
    {
        if (!is_null($email)) {
            WebmozartAssert::maxLength($email, 255, 'The email must be a 255 chars length. Got: %s');
            WebmozartAssert::email($email, 'The email must be a valid email address. Got: %s');
        }
    }

    private function phoneValidate(?string $phone = null): void
    {
        if (!is_null($phone)) {
            WebmozartAssert::maxLength($phone, 16, 'The email must be a 16 chars length. Got: %s');
            WebmozartAssert::digits($phone, 'The phone must be a numeric. Got: %s');
        }
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function changeName(
        string $lastName,
        string $firstName,
        ?string $middleName = null
    ): void
    {
        $this->lastNameValidate($lastName);
        $this->firstNameValidate($firstName);
        $this->middleNameValidate($middleName);

        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
    }

    public function changeContacts(
        ?string $email = null,
        ?string $phone = null
    ): void
    {
        $this->emailValidate($email);
        $this->phoneValidate($phone);

        $this->email = $email;
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return [
            'last_name' => $this->lastName,
            'first_name' => $this->firstName,
            'middle_name' => $this->middleName,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}

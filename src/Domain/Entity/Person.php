<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;

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

    /**
     * @throws Exception
     */
    public function __construct(
        string $lastName,
        string $firstName,
        ?string $middleName,
        ?string $phone,
        ?string $email
    )
    {
        if ($this->lastNameValidate($lastName) &&
            $this->firstNameValidate($firstName) &&
            $this->middleNameValidate($middleName) &&
            $this->phoneValidate($phone) &&
            $this->emailValidate($email)) {

            $this->lastName = $lastName;
            $this->firstName = $firstName;
            $this->middleName = $middleName;
            $this->phone = $phone;
            $this->email = $email;
        }
    }

    /**
     * @throws Exception
     */
    private function lastNameValidate(string $lastName): bool
    {
        $flag = false;
        if (mb_strlen($lastName) >= 2 && mb_strlen($lastName) <= 64)
            $flag = true;
        else
            throw new Exception('Last name must be a valid length of 2-64 letters.');

        return $flag;
    }

    /**
     * @throws Exception
     */
    private function firstNameValidate(string $firstName): bool
    {
        $flag = false;
        if (mb_strlen($firstName) >= 2 && mb_strlen($firstName) <= 64)
            $flag = true;
        else
            throw new Exception('First name must be a valid length of 2-64 letters.');

        return $flag;
    }

    /**
     * @throws Exception
     */
    private function middleNameValidate(?string $middleName = null): bool
    {
        $flag = false;
        if($middleName === null)
            $flag = true;
        elseif (mb_strlen($middleName) >= 2 && mb_strlen($middleName) <= 64)
            $flag = true;
        else
            throw new Exception('Middle name must be a valid length of 2-64 letters.');

        return $flag;
    }

    /**
     * @throws Exception
     */
    private function emailValidate(?string $email = null): bool
    {
        $flag = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            $flag = true;
        else
            throw new Exception('Wrong email address.');

        return $flag;
    }

    /**
     * @throws Exception
     */
    private function phoneValidate(?string $phone = null): bool
    {
        $flag = false;
        if(is_numeric($phone))
            $flag = true;
        else
            throw new Exception('Wrong phone number.');

        return $flag;
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

    /**
     * @throws Exception
     */
    public function changeName(
        ?string $lastName = null,
        ?string $firstName = null,
        ?string $middleName = null
    ): bool
    {
        if (!is_null($lastName) && $this->lastNameValidate($lastName))
            $this->lastName = $lastName;

        if (!is_null($firstName) && $this->firstNameValidate($firstName))
            $this->firstName = $firstName;

        if (!is_null($middleName) && $this->middleNameValidate($middleName))
            $this->middleName = $middleName;

        return true;
    }

    /**
     * @throws Exception
     */
    public function changeContacts(
        ?string $email = null,
        ?string $phone = null
    ): bool
    {
        if (!is_null($email) && $this->emailValidate($email))
            $this->email = $email;

        if (!is_null($phone) && $this->phoneValidate($phone))
            $this->phone = $phone;

        return true;
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

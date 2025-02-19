<?php

namespace App\Domain\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ConfirmationTrait
{
    #[ORM\Column(name: 'email_code', type: 'string', length: 6, unique: false, nullable: true, options: ['default' => null])]
    private string $emailCode;

    #[ORM\Column(name: 'email_confirmed', type: 'boolean', options: ['default' => false])]
    private bool $emailConfirmed = false;

    #[ORM\Column(name: 'phone_code', type: 'string', length: 6, unique: false, nullable: true, options: ['default' => null])]
    private string $phoneCode;

    #[ORM\Column(name: 'phone_confirmed', type: 'boolean', options: ['default' => false])]
    private bool $phoneConfirmed = false;

    public function getEmailCode(): string
    {
        return $this->emailCode;
    }

    public function setEmailCode(string $emailCode): void
    {
        $this->emailCode = $emailCode;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    public function setEmailConfirmed(bool $emailConfirmed): void
    {
        $this->emailConfirmed = $emailConfirmed;
    }

    public function getPhoneCode(): string
    {
        return $this->phoneCode;
    }

    public function setPhoneCode(string $phoneCode): void
    {
        $this->phoneCode = $phoneCode;
    }

    public function isPhoneConfirmed(): bool
    {
        return $this->phoneConfirmed;
    }

    public function setPhoneConfirmed(bool $phoneConfirmed): void
    {
        $this->phoneConfirmed = $phoneConfirmed;
    }
}

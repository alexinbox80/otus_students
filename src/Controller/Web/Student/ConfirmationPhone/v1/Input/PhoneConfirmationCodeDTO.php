<?php

namespace App\Controller\Web\Student\ConfirmationPhone\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class PhoneConfirmationCodeDTO
{
    public function __construct(
        #[Assert\Length(min:6)]
        #[Assert\Length(max:6)]
        public readonly ?string $phoneCode,
    ) {
    }
}

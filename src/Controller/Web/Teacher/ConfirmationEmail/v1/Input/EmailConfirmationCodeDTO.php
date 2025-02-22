<?php

namespace App\Controller\Web\Teacher\ConfirmationEmail\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class EmailConfirmationCodeDTO
{
    public function __construct(
        #[Assert\Length(min:6)]
        #[Assert\Length(max:6)]
        public readonly ?string $emailCode
    ) {
    }
}

<?php

namespace App\Controller\Web\User\DeleteUser\v1\Output;

use App\Controller\DTO\Interfaces\OutputDTOInterface;

class DeletedUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly bool $success,
    ) {
    }
}

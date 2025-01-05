<?php

namespace App\Controller\DTO;

use App\Controller\DTO\Interfaces\OutputDTONotFoundInterface;

class EmptyDTO implements OutputDTONotFoundInterface
{
    public function __construct()
    {
    }
}

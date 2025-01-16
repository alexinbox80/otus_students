<?php

namespace App\Controller\Web\Student\DeleteStudent\v1\Output;

use App\Controller\Common\ResultTrait;
use App\Controller\DTO\Interfaces\OutputDTOInterface;
use Symfony\Component\HttpFoundation\Response;

class DeletedStudentDTO implements OutputDTOInterface
{
    use ResultTrait;

    public function __construct(
    ) {
        $this->setSuccess(true);
        $this->setCode(Response::HTTP_OK);
    }
}

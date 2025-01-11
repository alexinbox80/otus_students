<?php

namespace App\Controller\Web\Skill\DeleteSkill\v1\Output;

use App\Controller\Common\ResultTrait;
use App\Controller\DTO\Interfaces\OutputDTOInterface;
use Symfony\Component\HttpFoundation\Response;

class DeletedSkillDTO implements OutputDTOInterface
{
    use ResultTrait;

    public function __construct(
    ) {
        $this->setSuccess(true);
        $this->setCode(Response::HTTP_OK);
    }
}

<?php

namespace App\Controller\Common;

class SuccessResponse
{
    use ResultTrait;

    public function __construct(string $message, int $code, bool $success = true)
    {
        $this->setSuccess($success);
        $this->setMessage($message);
        $this->setCode($code);
    }
}

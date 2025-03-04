<?php

namespace App\Controller\Amqp\SendEmailNotification\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('numeric')]
        public readonly int $userId,
        #[Assert\Type('string')]
        #[Assert\Length(max: 512)]
        public readonly string $text,
        #[Assert\Type('string')]
        #[Assert\Length(max: 1024)]
        public readonly string $description,
        #[Assert\Type('string')]
        #[Assert\Length(max: 128)]
        public readonly string $entityName,
    ) {
    }
}

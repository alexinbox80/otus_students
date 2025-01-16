<?php

namespace App\Controller\Web\Lesson\CreateLesson\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateLessonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min:8)]
        #[Assert\Length(max:128)]
        public readonly string $name,
        #[Assert\Length(min:8)]
        #[Assert\Length(max:255)]
        public readonly ?string $description
    ) {
    }
}

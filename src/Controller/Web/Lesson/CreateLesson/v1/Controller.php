<?php

namespace App\Controller\Web\Lesson\CreateLesson\v1;

use App\Controller\Web\Lesson\CreateLesson\v1\Input\CreateLessonDTO;
use App\Controller\Web\Lesson\CreateLesson\v1\Output\CreatedLessonDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    )
    {
    }

    #[Route(
        path: 'api/v1/lesson',
        name: 'web_create_lesson_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] CreateLessonDTO $createLessonDTO): CreatedLessonDTO
    {
        return $this->manager->create($createLessonDTO);
    }
}

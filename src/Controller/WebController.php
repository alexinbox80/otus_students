<?php

namespace App\Controller;

use App\Domain\Entity\Achievement;
use App\Domain\Entity\CompletedTask;
use App\Domain\Entity\Course;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Percentage;
use App\Domain\Entity\Person;
use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Entity\Subscription;
use App\Domain\Entity\Task;
use App\Domain\Entity\UnlockedAchievement;
use App\Domain\Entity\User;
use App\Domain\Service\AchievementService;
use App\Domain\Service\CompletedTaskService;
use App\Domain\Service\CourseService;
use App\Domain\Service\LessonService;
use App\Domain\Service\PercentageService;
use App\Domain\Service\SkillService;
use App\Domain\Service\StudentService;
use App\Domain\Service\SubscriptionService;
use App\Domain\Service\TaskService;
use App\Domain\Service\UnlockedAchievementService;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WebController extends AbstractController
{
    public function __construct(
        private readonly UserService                $userService,
        private readonly StudentService             $studentService,
        private readonly CourseService              $courseService,
        private readonly AchievementService         $achievementService,
        private readonly CompletedTaskService       $completedTaskService,
        private readonly LessonService              $lessonService,
        private readonly PercentageService          $percentageService,
        private readonly SkillService               $skillService,
        private readonly SubscriptionService        $subscriptionService,
        private readonly TaskService                $taskService,
        private readonly UnlockedAchievementService $unlockedAchievementService,
    )
    {
    }

    public function index(): Response
    {
//        $person = new Person(
//            'Petrov',
//            'Petr',
//            null,
//            null,
//            '1233214567'
//        );

        //$student = $this->studentService->create($person);

//        $student = $this->studentService->updateName(10, $person);
//        $student = $this->studentService->updateContact(10, $person);
//
//        return $this->json([
//            'student' => $student->toArray(),
//        ]);
//

        //$this->userService->create('user-login-123', 'user-password');
        $user = $this->userService->findAll();
        return $this->json([
            'user' => array_map(static fn (User $user) => $user->toArray(), $user)
        ]);

//        $student = $this->studentService->findAll();
//        return $this->json([
//            'student' => array_map(static fn(Student $student) => $student->toArray(), $student)
//        ]);

//        $this->achievementService->create(
//            'hello world 123',
//            'hello description'
//        );
//        $achievement = $this->achievementService->findAll();
//        return $this->json([
//            'achievement' => array_map(static fn (Achievement $achievement) => $achievement->toArray(), $achievement)
//        ]);

//        $student = $this->studentService->find(2);
//        $this->completedTaskService->create($student, 5, 'description', null);
//        $completedTask = $this->completedTaskService->findAll();
//        return $this->json([
//            'completedTask' => array_map(static fn (CompletedTask $completedTask) => $completedTask->toArray(), $completedTask)
//        ]);

        //$course = $this->courseService->find(3);
        //$this->lessonService->create($course, 'lesson name', null);
//        $lesson = $this->lessonService->findAll();
//        return $this->json([
//            'lesson' => array_map(static fn (Lesson $lesson) => $lesson->toArray(), $lesson)
//        ]);

//        $this->courseService->create('test 13', 'test description');
//        $course = $this->courseService->findAll();
//        return $this->json([
//            'course' => array_map(static fn (Course $course) => $course->toArray(), $course)
//        ]);

//        $task = $this->taskService->find(2);
//        $skill= $this->skillService->find(2);
//        $this->percentageService->create($task, $skill, 55.55, 'test description');
//        $percentage = $this->percentageService->findAll();
//        return $this->json([
//            'percentage' => array_map(static fn (Percentage $percentage) => $percentage->toArray(), $percentage)
//        ]);

//        $this->skillService->create('skill name 12312', 'test test ');
//        $skill = $this->skillService->findAll();
//        return $this->json([
//            'skill' => array_map(static fn (Skill $skill) => $skill->toArray(), $skill)
//        ]);

//        $subscription = $this->subscriptionService->findAll();
//        return $this->json([
//            'subscription' => array_map(static fn (Subscription $subscription) => $subscription->toArray(), $subscription)
//        ]);

//        $lesson = $this->lessonService->find(2);
//        $this->taskService->create($lesson, 'task name', null);
//        $task = $this->taskService->findAll();
//        return $this->json([
//            'task' => array_map(static fn (Task $task) => $task->toArray(), $task)
//        ]);

//        $unlockedAchievement = $this->unlockedAchievementService->findAll();
//        return $this->json([
//            'unlockedAchievement' => array_map(static fn (UnlockedAchievement $unlockedAchievement) => $unlockedAchievement->toArray(), $unlockedAchievement)
//        ]);
    }
}

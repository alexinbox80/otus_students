<?php

namespace App\Domain\Service;

use App\Domain\Entity\Course;
use App\Domain\Entity\Student;
use App\Domain\Entity\Subscription;
use App\Domain\Entity\Task;
use App\Infrastructure\Repository\SubscriptionRepository;

class SubscriptionService
{
    public function __construct(
        private readonly SubscriptionRepository $subscriptionRepository
    )
    {
    }

    /**
     * @param int $subscriptionId
     * @return Subscription
     */
    public function find(int $subscriptionId): Subscription
    {
        return $this->subscriptionRepository->find($subscriptionId);
    }

    /**
     * @return Subscription[]
     */
    public function findAll(): array
    {
        return $this->subscriptionRepository->findAll();
    }

    /**
     * @param Student $student
     * @param Course $course
     * @return Subscription
     */
    public function create(Student $student, Course $course): Subscription
    {
        $subscription = new Subscription();
        $subscription->setStudent($student);
        $subscription->setCourse($course);
        $this->subscriptionRepository->create($subscription);

        return $subscription;
    }

    public function changeSubscription(Student $student, Course $course): Subscription
    {
        $subscription = new Subscription();
        $subscription->setStudent($student);
        $subscription->setCourse($course);
        $this->subscriptionRepository->flush();

        return $subscription;
    }

    /**
     * @param int $subscriptionId
     * @return void
     */
    public function removeById(int $subscriptionId): void
    {
        $subscription = $this->subscriptionRepository->find($subscriptionId);
        if ($subscription instanceof Subscription) {
            $this->subscriptionRepository->remove($subscription);
        }
    }
}

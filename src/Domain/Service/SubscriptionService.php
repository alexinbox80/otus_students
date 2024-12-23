<?php

namespace App\Domain\Service;

use App\Domain\Entity\Course;
use App\Domain\Entity\Student;
use App\Domain\Entity\Subscription;
use App\Infrastructure\Repository\SubscriptionRepository;

class SubscriptionService
{
    public function __construct(
        private readonly SubscriptionRepository $subscriptionRepository
    )
    {
    }

    /**
     * @param Student $student
     * @param Course $course
     * @return Subscription
     */
    public function subscribe(Student $student, Course $course): Subscription
    {
        $subscription = new Subscription();
        $subscription->setStudent($student);
        $subscription->setCourse($course);
        $this->subscriptionRepository->create($subscription);

        return $subscription;
    }
}

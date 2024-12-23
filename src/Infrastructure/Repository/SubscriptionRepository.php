<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Subscription;

class SubscriptionRepository extends AbstractRepository
{
    /**
     * @param Subscription $subscription
     * @return int
     */
    public function create(Subscription $subscription): int
    {
        return $this->store($subscription);
    }
}

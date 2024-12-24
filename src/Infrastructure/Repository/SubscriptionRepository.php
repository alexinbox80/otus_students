<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Subscription;

class SubscriptionRepository extends AbstractRepository
{
    /**
     * @param int $subscriptionId
     * @return Subscription|null
     */
    public function find(int $subscriptionId): ?Subscription
    {
        $repository = $this->entityManager->getRepository(Subscription::class);
        /** @var Subscription|null $subscription */
        $subscription = $repository->find($subscriptionId);

        return $subscription;
    }

    /**
     * @return Subscription[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Subscription::class)->findAll();
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->flush();
    }

    /**
     * @param Subscription $subscription
     * @return int
     */
    public function create(Subscription $subscription): int
    {
        return $this->store($subscription);
    }

    /**
     * @param Subscription $subscription
     * @return void
     */
    public function remove(Subscription $subscription): void
    {
        $subscription->setDeletedAt();
        $this->flush();
    }
}

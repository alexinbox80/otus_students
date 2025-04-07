<?php

namespace App\Controller\Web\Sales\Subscribe\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\Subscribe\v1\Input\SubscribeDTO;
use App\Controller\Web\Sales\Subscribe\v1\Output\SubscribedDTO;
use DateTimeImmutable;

class Manager
{
    public function __construct(
        private SalesInterface $sales,
    ) {
    }

    public function subscribe(SubscribeDTO $subscribeDTO): SubscribedDTO
    {
        try {
            $subscriptionId = $this->sales->subscribe(
                $subscribeDTO->userId,
                $subscribeDTO->productId,
                new DateTimeImmutable()
            );
        } catch (\Exception $e) {
            // TODO Handle
            throw new $e;
        }

        return new SubscribedDTO(
            true,
            $subscriptionId
        );
    }
}

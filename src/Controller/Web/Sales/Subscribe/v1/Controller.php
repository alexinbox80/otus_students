<?php

namespace App\Controller\Web\Sales\Subscribe\v1;

use App\Controller\Web\Sales\Subscribe\v1\Input\SubscribeDTO;
use App\Controller\Web\Sales\Subscribe\v1\Output\SubscribedDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class Controller
{
    public function __construct(
        private Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/create-paid-subscription',
        name: 'web_create_paid_subscription_v1_invoke',
        methods: ['POST']
    )]
    public function __invoke(#[MapRequestPayload] SubscribeDTO $subscribeDTO): SubscribedDTO
    {
        return $this->manager->subscribe($subscribeDTO);
    }
}

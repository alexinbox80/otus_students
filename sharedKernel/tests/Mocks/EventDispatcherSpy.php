<?php

namespace alexinbox80\Shared\Tests\Mocks;

use alexinbox80\Shared\Domain\EventDispatcherInterface;
use alexinbox80\Shared\Domain\Events\DomainEventInterface;

class EventDispatcherSpy implements EventDispatcherInterface
{
    /** @var DomainEventInterface[] */
    public array $recordedEvents = [];

    public function __construct(
        private ?EventDispatcherInterface $realEventDispatcher = null
    ) {
    }

    public function dispatch(DomainEventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->recordedEvents[] = $event;

            if ($this->realEventDispatcher !== null) {
                $this->realEventDispatcher->dispatch($event);
            }
        }
    }

    /**
     * @return DomainEventInterface[]
     */
    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }
}

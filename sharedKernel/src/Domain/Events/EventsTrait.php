<?php

namespace alexinbox80\Shared\Domain\Events;

/**
 * Добавляет возможность агрегату записывать события, генерируемые в мутаторах.
 *
 * Трейты в целом - антипаттерн и зло.
 * Однако в данном конкретном случае удобно использовать именно трейт для добавления поведения агрегату.
 * Этот трейт должен использоваться только с Агрегатами, имплементирующими AggregateRootInterface
 * @see \alexinbox80\Shared\Domain\Model\AggregateRootInterface
 */
trait EventsTrait
{
    /** @var DomainEventInterface[] */
    private array $recordedEvents = [];

    /**
     * @return DomainEventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    public function recordEvent(DomainEventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }
}

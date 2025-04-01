<?php

namespace alexinbox80\Shared\Domain\Model;

use alexinbox80\Shared\Domain\Events\DomainEventInterface;

interface AggregateRootInterface
{
    public function recordEvent(DomainEventInterface $event): void;
    public function releaseEvents(): array;
}

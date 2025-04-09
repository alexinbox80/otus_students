<?php

namespace alexinbox80\Shared\Domain;

use alexinbox80\Shared\Domain\Events\DomainEventInterface;

interface EventDispatcherInterface
{
    public function dispatch(DomainEventInterface ...$events): void;
}

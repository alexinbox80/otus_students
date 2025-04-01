<?php

namespace alexinbox80\Shared\Domain;

namespace alexinbox80\Shared\Domain;

/**
 * Interface for flushing pending UnitOfWork changes.
 */
interface FlusherInterface
{
    public function flush(?string $className = null): void;
}

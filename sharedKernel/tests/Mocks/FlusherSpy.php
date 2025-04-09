<?php

namespace alexinbox80\Shared\Tests\Mocks;

use alexinbox80\Shared\Domain\FlusherInterface;

final class FlusherSpy implements FlusherInterface
{
    public array $flushed = [];

    public function flush(?string $className = null): void
    {
        $this->flushed[] = $className;
    }
}

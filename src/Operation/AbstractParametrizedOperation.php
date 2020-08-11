<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Generator;

abstract class AbstractParametrizedOperation
{
    /**
     * @var array<string, mixed>
     */
    protected $storage = [];

    /**
     * @psalm-return Generator<int, mixed>
     */
    public function getArguments(): Generator
    {
        return yield from array_values($this->storage);
    }
}

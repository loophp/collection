<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;
use Generator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Operation
{
    public function __invoke(): Closure;

    /**
     * @return Generator<int, mixed>
     */
    public function getArguments(): Generator;
}

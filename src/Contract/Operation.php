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

    public function call(callable $callable, ...$arguments);

    /**
     * @return Generator<int, mixed>
     * @psalm-return Generator<int, T>
     */
    public function getArguments(): Generator;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface LazyOperation extends Operation
{
    /**
     * @psalm-return \Closure(\Iterator<TKey, T>, Operation...):(\Iterator<TKey, T>)
     */
    public function __invoke(): Closure;

    /**
     * @psalm-param \Closure(\Iterator $collection, Operation...):(\Iterator<TKey, T>) $callable
     *
     * @param mixed ...$arguments
     * @psalm-param T ...$arguments
     *
     * @return mixed
     * @psalm-return \Iterator<TKey, T>
     */
    public function call(callable $callable, ...$arguments): Iterator;
}

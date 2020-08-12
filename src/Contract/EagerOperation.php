<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface EagerOperation extends Operation
{
    /**
     * @psalm-return \Closure(\Iterator<TKey, T>, Operation...):(T|\Iterator<TKey, T>|scalar|null)
     */
    public function __invoke(): Closure;

    /**
     * @psalm-param \Closure(\Iterator $collection, Operation...):(T|\Iterator<TKey, T>|scalar|null) $callable
     *
     * @param mixed ...$arguments
     * @psalm-param T ...$arguments
     *
     * @return mixed
     * @psalm-return T|\Iterator<TKey, T>|scalar|null
     */
    public function call(callable $callable, ...$arguments);
}

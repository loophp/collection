<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Firstable
{
    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param callable $callback
     * @psalm-param callable(T, TKey):(bool) $callback
     *
     * @param mixed $default
     * @psalm-param T|null $default
     *
     * @return mixed
     * @psalm-return T|null
     */
    public function first(?callable $callback = null, $default = null);
}

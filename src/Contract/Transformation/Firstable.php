<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Firstable
{
    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @psalm-param null|callable(T, TKey):(bool) $callback
     *
     * @param mixed $default
     * @psalm-param T|null $default
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function first(?callable $callback = null, $default = null);
}

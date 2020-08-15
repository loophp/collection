<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Lastable
{
    /**
     * Get the last item from the collection passing the given truth test.
     *
     * @psalm-param null|callable(T, TKey):(bool) $callback
     *
     * @param mixed|null $default
     * @psalm-param T|null $default
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function last(?callable $callback = null, $default = null);
}

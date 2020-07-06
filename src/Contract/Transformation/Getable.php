<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Getable
{
    /**
     * Get an item by key.
     *
     * @template U
     *
     * @param TKey $key
     * @param U $default
     *
     * @return T|U
     */
    public function get($key, $default = null);
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Getable
{
    /**
     * Get a specific element of the collection from a key; if the key doesn't exist, returns the default value.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#get
     *
     * @template V
     *
     * @param TKey $key
     * @param V $default
     *
     * @return T|V
     */
    public function get($key, $default = null);
}

<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Getable.
 */
interface Getable
{
    /**
     * Get an item by key.
     *
     * @param int|string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);
}

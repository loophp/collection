<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Firstable.
 */
interface Firstable
{
    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param null|callable $callback
     * @param mixed $default
     *
     * @return mixed
     */
    public function first(callable $callback = null, $default = null);
}

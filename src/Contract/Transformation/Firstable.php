<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Firstable
{
    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param callable|null $callback
     * @param mixed $default
     *
     * @return mixed
     */
    public function first(?callable $callback = null, $default = null);
}

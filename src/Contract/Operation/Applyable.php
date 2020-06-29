<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable ...$callables
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function apply(callable ...$callables): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Applyable.
 */
interface Applyable
{
    /**
     * Execute a callback for each element of the collection.
     *
     * @param callable ...$callables
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function apply(callable ...$callables): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Appendable.
 */
interface Applyable
{
    /**
     * Apply a callback to all the element of an array.
     *
     * @param callable ...$callables
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function apply(callable ...$callables): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Permutateable.
 */
interface Permutateable
{
    /**
     * Find all the permutations of a collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function permutate(): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Permutateable.
 */
interface Permutateable
{
    /**
     * TODO: Permutations.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function permutate(): Base;
}

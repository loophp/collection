<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Columnable.
 */
interface Columnable
{
    /**
     * Return the values from a single column in the input iterables.
     *
     * @param int|string $index
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function column($index): Base;
}

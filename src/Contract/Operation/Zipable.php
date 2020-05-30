<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Zipable.
 */
interface Zipable
{
    /**
     * Zip a collection together with one or more iterables.
     *
     * @param iterable ...$iterables
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function zip(iterable ...$iterables): Base;
}

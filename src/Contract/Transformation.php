<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Transformation.
 */
interface Transformation
{
    /**
     * @param iterable<mixed> $collection
     *
     * @return bool|mixed
     */
    public function on(iterable $collection);
}

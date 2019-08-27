<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * @param iterable $collection
     *
     * @return mixed
     */
    public function on(iterable $collection);
}

<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * @param \Traversable $collection
     *
     * @return mixed
     */
    public function on(\Traversable $collection);
}

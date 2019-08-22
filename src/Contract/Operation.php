<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * @param \drupol\collection\Contract\BaseCollection $collection
     *
     * @return mixed
     */
    public function run(BaseCollection $collection);
}

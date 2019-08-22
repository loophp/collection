<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Runable.
 */
interface Runable
{
    /**
     * @param \drupol\collection\Contract\Operation ...$operations
     *
     * @return bool|int|mixed
     */
    public function run(Operation ...$operations);
}

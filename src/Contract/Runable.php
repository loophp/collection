<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Runable.
 */
interface Runable
{
    /**
     * @param \loophp\collection\Contract\Operation ...$operations
     *
     * @return bool|int|mixed
     */
    public function run(Operation ...$operations);
}

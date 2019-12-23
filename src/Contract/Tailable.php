<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Tailable.
 */
interface Tailable
{
    /**
     * @param int $length
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function tail(int $length): Base;
}

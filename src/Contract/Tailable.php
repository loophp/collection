<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Tailable.
 */
interface Tailable
{
    /**
     * @param int $length
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function tail(int $length): Base;
}

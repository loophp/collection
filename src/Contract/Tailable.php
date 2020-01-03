<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Tailable.
 */
interface Tailable
{
    /**
     * TODO: Tail.
     *
     * @param int $length
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function tail(int $length = 1): Base;
}

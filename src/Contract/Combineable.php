<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Combineable.
 */
interface Combineable
{
    /**
     * @param mixed $keys
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function combine($keys): Base;
}

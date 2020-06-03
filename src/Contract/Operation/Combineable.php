<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Combineable.
 */
interface Combineable
{
    /**
     * Combine a collection of items with some other keys.
     *
     * @param mixed ...$keys
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function combine(...$keys): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Combinateable.
 */
interface Combinateable
{
    /**
     * Get all the combinations of a given length of a collection of items.
     *
     * @param int $length
     *   The length.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function combinate(?int $length = null): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Filterable.
 */
interface Filterable
{
    /**
     * Filter collection items based on one or more callbacks.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function filter(callable ...$callbacks): Base;
}

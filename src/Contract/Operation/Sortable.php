<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Sortable.
 */
interface Sortable
{
    /**
     * Sort a collection using a callback.
     *
     * @param callable $callable
     *
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function sort(?callable $callable = null): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Sortable
{
    /**
     * Sort a collection using a callback.
     *
     * @param callable|null $callable
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function sort(?callable $callable = null): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Sortable
{
    /**
     * Sort a collection using a callback.
     */
    public function sort(?callable $callable = null): Collection;
}

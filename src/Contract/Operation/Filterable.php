<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Filterable
{
    /**
     * Filter collection items Collectiond on one or more callbacks.
     *
     * @param callable ...$callbacks
     */
    public function filter(callable ...$callbacks): Collection;
}

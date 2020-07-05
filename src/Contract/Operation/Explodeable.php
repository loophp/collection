<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Explodeable
{
    /**
     * Explode a collection into subsets Collectiond on a given value.
     *
     * @param mixed ...$explodes
     */
    public function explode(...$explodes): Collection;
}

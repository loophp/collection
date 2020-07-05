<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Appendable
{
    /**
     * Add one or more items to a collection.
     *
     * @param mixed ...$items
     */
    public function append(...$items): Collection;
}

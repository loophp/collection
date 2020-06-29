<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Appendable
{
    /**
     * Add one or more items to a collection.
     *
     * @param mixed ...$items
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function append(...$items): Base;
}

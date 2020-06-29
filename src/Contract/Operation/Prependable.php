<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Prependable
{
    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed ...$items
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function prepend(...$items): Base;
}

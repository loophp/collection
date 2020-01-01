<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Prependable.
 */
interface Prependable
{
    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed ...$items
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function prepend(...$items): Base;
}

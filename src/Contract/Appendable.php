<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Appendable.
 */
interface Appendable
{
    /**
     * Add one or more items to a collection.
     *
     * @param mixed ...$items
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function append(...$items): Base;
}

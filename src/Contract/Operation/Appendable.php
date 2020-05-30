<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

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

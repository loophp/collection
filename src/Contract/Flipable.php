<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Flipable.
 */
interface Flipable
{
    /**
     * Flip the items in the collection.
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function flip(): Base;
}

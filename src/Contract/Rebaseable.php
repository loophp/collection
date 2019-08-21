<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Rebaseable.
 */
interface Rebaseable
{
    /**
     * @return \drupol\collection\Contract\BaseCollection
     */
    public function rebase(): BaseCollection;
}

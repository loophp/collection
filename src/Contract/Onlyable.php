<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Onlyable.
 */
interface Onlyable
{
    /**
     * Get the items with the specified keys.
     *
     * @param mixed ...$keys
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function only(...$keys): Base;
}

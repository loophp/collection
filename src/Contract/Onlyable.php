<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Onlyable.
 */
interface Onlyable
{
    /**
     * Get items having corresponding given keys.
     *
     * @param mixed ...$keys
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function only(...$keys): Base;
}

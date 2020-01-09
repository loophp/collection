<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * Interface Forgetable.
 */
interface Forgetable
{
    /**
     * Remove items having specific keys.
     *
     * @param string ...$keys
     *
     * @return \loophp\collection\Contract\Collection<mixed>
     */
    public function forget(...$keys): Base;
}

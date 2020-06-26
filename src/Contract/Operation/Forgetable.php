<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

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
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function forget(...$keys): Base;
}

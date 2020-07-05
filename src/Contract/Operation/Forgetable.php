<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Forgetable
{
    /**
     * Remove items having specific keys.
     *
     * @param mixed ...$keys
     */
    public function forget(...$keys): Collection;
}

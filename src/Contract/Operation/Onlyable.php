<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Onlyable
{
    /**
     * Get items having corresponding given keys.
     *
     * @param mixed ...$keys
     */
    public function only(...$keys): Collection;
}

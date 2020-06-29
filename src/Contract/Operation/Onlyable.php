<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Onlyable
{
    /**
     * Get items having corresponding given keys.
     *
     * @param mixed ...$keys
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function only(...$keys): Base;
}

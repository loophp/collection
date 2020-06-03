<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

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
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function only(...$keys): Base;
}

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
     * @return \loophp\collection\Base<mixed>|\loophp\collection\Contract\Collection<mixed>
     */
    public function forget(...$keys): Base;
}

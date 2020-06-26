<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Windowable.
 */
interface Windowable
{
    /**
     * @param int ...$length
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function window(int ...$length): Base;
}

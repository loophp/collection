<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Loopable.
 */
interface Loopable
{
    /**
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function loop(): Base;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Keysable
{
    /**
     * Get the keys of the items.
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function keys(): Base;
}

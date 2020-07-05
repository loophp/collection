<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Keysable
{
    /**
     * Get the keys of the items.
     */
    public function keys(): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Flipable
{
    /**
     * Flip keys and items in a collection.
     */
    public function flip(): Collection;
}

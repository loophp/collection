<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Shuffleable
{
    /**
     * Shuffle a collection.
     */
    public function shuffle(): Collection;
}

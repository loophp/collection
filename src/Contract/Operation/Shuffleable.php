<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Shuffleable
{
    /**
     * Shuffle a collection.
     */
    public function shuffle(): Base;
}

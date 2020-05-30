<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

/**
 * Interface Shuffleqble.
 */
interface Shuffleable
{
    /**
     * Shuffle a collection.
     *
     * @return \loophp\collection\Contract\Base
     */
    public function shuffle(): Base;
}

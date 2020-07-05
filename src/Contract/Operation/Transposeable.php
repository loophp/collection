<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Transposeable
{
    /**
     * Matrix transposition.
     */
    public function transpose(): Collection;
}

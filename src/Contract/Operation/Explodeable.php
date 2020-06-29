<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Explodeable
{
    /**
     * Explode a collection into subsets based on a given value.
     *
     * @param mixed ...$explodes
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function explode(...$explodes): Base;
}

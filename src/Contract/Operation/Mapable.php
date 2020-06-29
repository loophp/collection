<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Mapable
{
    /**
     * Apply one or more callbacks to a collection and use the return value.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function map(callable ...$callbacks): Base;
}

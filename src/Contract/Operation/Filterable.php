<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Filterable
{
    /**
     * Filter collection items based on one or more callbacks.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function filter(callable ...$callbacks): Base;
}

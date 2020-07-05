<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Splitable
{
    /**
     * Split a collection using a callback.
     *
     * @param callable ...$callbacks
     */
    public function split(callable ...$callbacks): Collection;
}

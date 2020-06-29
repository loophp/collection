<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Splitable
{
    /**
     * Split a collection using a callback.
     *
     * @param callable ...$callbacks
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function split(callable ...$callbacks): Base;
}

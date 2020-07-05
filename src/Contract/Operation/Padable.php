<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @param mixed $value
     */
    public function pad(int $size, $value): Collection;
}

<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Base;

interface Padable
{
    /**
     * Pad a collection to the given length with a given value.
     *
     * @param mixed $value
     * @param int $size
     *
     * @return \loophp\collection\Base|\loophp\collection\Contract\Collection
     */
    public function pad(int $size, $value): Base;
}

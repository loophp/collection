<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Currentable
{
    /**
     * @psalm-return T
     */
    public function current(int $index = 0);
}

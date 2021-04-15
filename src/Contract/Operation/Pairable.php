<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Pairable
{
    /**
     * @psalm-return \loophp\collection\Collection<T|TKey, T>
     */
    public function pair(): Collection;
}

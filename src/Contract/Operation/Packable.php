<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Packable
{
    /**
     * @psalm-return \loophp\collection\Contract\Collection<int, array{0: TKey, 1: T}>
     */
    public function pack(): Collection;
}

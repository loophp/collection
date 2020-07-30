<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Frequencyable
{
    /**
     * @return \loophp\collection\Contract\Collection<TKey, T>
     */
    public function frequency(): Collection;
}

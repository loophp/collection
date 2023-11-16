<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Entropyable
{
    /**
     * Calculate the normalized Shannon entropy for each collection items.
     *
     * If you're looking for one single result, you must get the last item using
     * `last` operation.
     *
     * @see https://en.wikipedia.org/wiki/Entropy_(information_theory)
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#entropy
     *
     * @return Collection<int, int<0,1>|float>
     */
    public function entropy(): Collection;
}

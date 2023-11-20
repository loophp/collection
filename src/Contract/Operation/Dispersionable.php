<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Dispersionable
{
    /**
     * This method extends the library's functionality by allowing users to calculate
     * a dispersion value using the amount of value changes within the collection.
     *
     * For example, the set `[a, b, a]` contains three elements and two changes.
     * From `a` to `b` and from `b` to `a`. Therefore, the dispersion value is
     * `2 / 2 = 1`.
     *
     * The dispersion value is normalized between `0` and `1`. A dispersion of `0`
     * indicates no dispersion, while a dispersion of `1` means maximum dispersion.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#dispersion
     *
     * @return Collection<int, float|int<0,1>>
     */
    public function dispersion(): Collection;
}

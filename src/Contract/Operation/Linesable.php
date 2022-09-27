<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template TKey
 * @template T
 */
interface Linesable
{
    /**
     * Split a string into lines.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#lines
     *
     * @return Collection<int, string>
     */
    public function lines(): Collection;
}

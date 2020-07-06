<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

/**
 * @template T
 */
interface Frequencyable
{
    /**
     * @return Collection<int, T>
     */
    public function frequency(): Collection;
}

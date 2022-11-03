<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @template T
 */
interface Withable
{
    /**
     * @param array<int, mixed> $arguments
     *
     * @return Collection<TKey, T>
     */
    public function with(Operation $operation, array $arguments = []): Collection;
}

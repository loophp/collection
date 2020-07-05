<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Pluckable
{
    /**
     * Retrieves all of the values of a collection for a given key.
     *
     * @param array<int, string>|string $pluck
     * @param mixed|null $default
     */
    public function pluck($pluck, $default = null): Collection;
}

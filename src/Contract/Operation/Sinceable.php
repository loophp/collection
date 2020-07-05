<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use loophp\collection\Contract\Collection;

interface Sinceable
{
    /**
     * @param callable ...$callbacks
     */
    public function since(callable ...$callbacks): Collection;
}

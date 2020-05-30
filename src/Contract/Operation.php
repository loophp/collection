<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * @return Closure
     */
    public function __invoke(): Closure;
}

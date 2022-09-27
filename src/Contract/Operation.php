<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

/**
 * @immutable
 */
interface Operation
{
    public function __invoke(): Closure;

    public static function of(): Closure;
}

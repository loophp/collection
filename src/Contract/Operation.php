<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

interface Operation
{
    public function __invoke(): Closure;

    public static function of(): Closure;
}

<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use const PHP_EOL;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Unlines extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, (T|string)>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        return (new Implode())()(PHP_EOL);
    }
}

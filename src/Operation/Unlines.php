<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

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
     * @pure
     *
     * @return Closure(Iterator<TKey, (T|string)>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, (T|string)>):Generator<TKey, string> $implode */
        $implode = Implode::of()(PHP_EOL);

        // Point free style.
        return $implode;
    }
}

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

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Unwords extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, (T|string)>): Generator<TKey, string, mixed, void>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, (T|string)>): Generator<TKey, string, mixed, void> $implode */
        $implode = Implode::of()(' ');

        // Point free style.
        return $implode;
    }
}

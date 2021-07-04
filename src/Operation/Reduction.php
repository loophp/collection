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
use loophp\fpt\FPT;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Reduction extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>): (T|null)):Closure (T|null): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return FPT::reduction();
    }
}

<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Slice extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(int=): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int=): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (int $offset): Closure =>
                /**
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static function (int $length = -1) use ($offset): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $skip */
                    $skip = (new Drop())()($offset);

                    if (-1 === $length) {
                        return $skip;
                    }

                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = (new Pipe())()(
                        $skip,
                        (new Limit())()($length)(0)
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}

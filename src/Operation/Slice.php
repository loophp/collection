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
 * @template TKey of array-key
 * @template T
 */
final class Slice extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (int $offset): Closure =>
                /**
                 * @psalm-param int $length
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static function (int $length = -1) use ($offset): Closure {
                    /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $skip */
                    $skip = Drop::of()($offset);

                    if (-1 === $length) {
                        return $skip;
                    }

                    /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = Pipe::of()(
                        $skip,
                        Limit::of()($length)(0)
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}

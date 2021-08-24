<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Combine extends AbstractOperation
{
    /**
     * @pure
     *
     * @template U
     *
     * @return Closure(U...): Closure(Iterator<TKey, T>): Generator<null|U, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U ...$keys
             *
             * @return Closure(Iterator<TKey, T>): Generator<null|U, null|T>
             */
            static function (...$keys): Closure {
                $buildMultipleIterator =
                    /**
                     * @param Iterator<int, U> $keyIterator
                     */
                    static function (Iterator $keyIterator): Closure {
                        return
                            /**
                             * @param Iterator<TKey, T> $iterator
                             *
                             * @return MultipleIterator
                             */
                            static function (Iterator $iterator) use ($keyIterator): MultipleIterator {
                                $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

                                $mit->attachIterator($keyIterator);
                                $mit->attachIterator($iterator);

                                return $mit;
                            };
                    };

                /** @var Closure(Iterator<TKey, T>): Generator<null|U, null|T> $pipe */
                $pipe = Pipe::of()(
                    $buildMultipleIterator(new ArrayIterator($keys)),
                    Flatten::of()(1),
                    Pair::of(),
                );

                // Point free style.
                return $pipe;
            };
    }
}

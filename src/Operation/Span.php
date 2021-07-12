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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Span extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T, TKey, Iterator<TKey, T>): bool): Closure(Iterator<TKey, T>): Generator<int, Iterator<TKey, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, Iterator<TKey, T>): bool ...$callbacks
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, Iterator<TKey, T>>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Generator<int, Iterator<TKey, T>>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    /** @var Iterator<TKey, T> $takeWhile */
                    $takeWhile = TakeWhile::of()(...$callbacks)($iterator);
                    /** @var Iterator<TKey, T> $dropWhile */
                    $dropWhile = DropWhile::of()(...$callbacks)($iterator);

                    return yield from [$takeWhile, $dropWhile];
                };
    }
}

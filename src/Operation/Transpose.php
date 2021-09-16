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
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Transpose extends AbstractOperation
{
    /**
     * @pure
     *
     * @psalm-suppress ImpureMethodCall - using MultipleIterator as an internal tool which is not returned
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys =
            /**
             * @param non-empty-array<int, TKey> $key
             *
             * @return TKey
             */
            static fn (array $key) => reset($key);

        $callbackForValues =
            /**
             * @param array<int, T> $value
             *
             * @return array<int, T>
             */
            static fn (array $value): array => $value;

        /** @var Closure(Iterator<TKey, T>): Generator<TKey, list<T>> $pipe */
        $pipe = Pipe::of()(
            Reduce::of()(
                static function (MultipleIterator $acc, iterable $iterable): MultipleIterator {
                    $acc->attachIterator(new IterableIterator($iterable));

                    return $acc;
                }
            )(new MultipleIterator(MultipleIterator::MIT_NEED_ANY)),
            Flatten::of()(1),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}

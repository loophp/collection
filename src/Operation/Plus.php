<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Collection;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Plus extends AbstractOperation
{
    /**
     * @template UKey
     * @template U
     *
     * @return Closure(iterable<UKey, U>): Closure(iterable<TKey, T>): iterable<int|TKey|UKey, T|U>
     */
    public function __invoke(): Closure
    {
        $comparatorCallback =
            /**
             * @param T $left
             *
             * @return Closure(T): bool
             */
            static fn (mixed $left): Closure =>
                /**
                 * @param T $right
                 */
                static fn (mixed $right): bool => $left === $right;

        return
            /**
             * @param iterable<UKey, U> $items
             *
             * @return Closure(iterable<TKey, T>): iterable<int|TKey|UKey, T|U>
             */
            static fn (iterable $items): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int|TKey|UKey, T|U>
                 */
                static function (iterable $iterable) use ($items): Generator {
                    $collection = Collection::fromIterable($iterable)->squash();

                    foreach ($collection as $key => $value) {
                        yield $key => $value;
                    }

                    foreach ($items as $key => $value) {
                        if ($collection->keys()->contains($key)) {
                            continue;
                        }

                        yield $key => $value;
                    }
                };
    }
}

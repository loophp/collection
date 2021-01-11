<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Transpose extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, list<T>>
             */
            static function (Iterator $iterator): Generator {
                $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

                foreach ($iterator as $iterableIterator) {
                    $mit->attachIterator(new IterableIterator($iterableIterator));
                }

                $callbackForKeys =
                    /**
                     * @psalm-param array $carry
                     * @psalm-param array<int, TKey> $key
                     *
                     * @psalm-return TKey
                     */
                    static fn (array $carry, array $key) => current($key);

                $callbackForValues =
                    /**
                     * @psalm-param array $carry
                     * @psalm-param array<int, TKey> $key
                     * @psalm-param array<int, T> $value
                     *
                     * @psalm-return array<int, T>
                     */
                    static fn (array $carry, array $key, array $value): array => $value;

                /** @psalm-var Generator<TKey, list<T>> $associate */
                $associate = Associate::of()($callbackForKeys)($callbackForValues)($mit);

                return $associate;
            };
    }
}

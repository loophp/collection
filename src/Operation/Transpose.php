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
 * @template TKey of array-key
 * @template T
 */
final class Transpose extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, list<T>>
             */
            static function (Iterator $iterator): Generator {
                $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

                foreach ($iterator as $iterableIterator) {
                    $mit->attachIterator(new IterableIterator($iterableIterator));
                }

                $callbackForKeys =
                    /**
                     * @param array $carry
                     * @param array<int, TKey> $key
                     *
                     * @return TKey
                     */
                    static fn (array $carry, array $key) => current($key);

                $callbackForValues =
                    /**
                     * @param array $carry
                     * @param array<int, TKey> $key
                     * @param array<int, T> $value
                     *
                     * @return array<int, T>
                     */
                    static fn (array $carry, array $key, array $value): array => $value;

                /** @var Generator<TKey, list<T>> $associate */
                $associate = Associate::of()($callbackForKeys)($callbackForValues)($mit);

                return $associate;
            };
    }
}

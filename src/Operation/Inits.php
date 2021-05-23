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
final class Inits extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        $scanLeftCallback =
            /**
             * @psalm-param array<TKey, T> $carry
             * @psalm-param T $value
             * @psalm-param TKey $key
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @param mixed $value
             * @param mixed $key
             *
             * @return array<TKey, T>
             */
            static function (array $carry, $value, $key): array {
                $carry[$key] = $value;

                return $carry;
            };

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, list<T>> $inits */
        $inits = Pipe::of()(
            ScanLeft::of()($scanLeftCallback)([]),
            Normalize::of()
        );

        // Point free style.
        return $inits;
    }
}

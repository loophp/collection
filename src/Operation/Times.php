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
final class Times extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(null|callable(int): (int|T)): Closure(null|Iterator<TKey, T>): Generator<int, int|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(null|callable(int): (int|T)): Closure(null|Iterator<TKey, T>): Generator<int, int|T>
             */
            static fn (int $number = 0): Closure =>
                /**
                 * @return Closure(null|Iterator<TKey, T>): Generator<int, int|T>
                 */
                static fn (?callable $callback = null): Closure =>
                    /**
                     * @param Iterator<TKey, T>|null $iterator
                     *
                     * @return Generator<int, int|T>
                     */
                    static function (?Iterator $iterator = null) use ($number, $callback): Generator {
                        if (1 > $number) {
                            return;
                        }

                        $callback ??= static fn (int $value): int => $value;

                        for ($current = 1; $current <= $number; ++$current) {
                            yield $callback($current);
                        }
                    };
    }
}

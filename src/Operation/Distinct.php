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
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Distinct extends AbstractOperation
{
    /**
     * @return Closure(callable(mixed): (Closure(mixed): bool)): Closure(callable(T, TKey): mixed): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(mixed): (Closure(mixed): bool) $comparatorCallback
             *
             * @return Closure(callable(T, TKey): mixed): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $comparatorCallback): Closure =>
                /**
                 * @param callable(T, TKey): mixed $accessorCallback
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static function (callable $accessorCallback) use ($comparatorCallback): Closure {
                    $foldLeftCallbackBuilder =
                        static fn (callable $accessorCallback): Closure => static fn (callable $comparatorCallback): Closure =>
                            /**
                             * @param list<array{0: TKey, 1: T}> $seen
                             * @param array{0: TKey, 1: T} $value
                             */
                            static function (array $seen, array $value) use ($accessorCallback, $comparatorCallback): array {
                                $isSeen = false;
                                $comparator = $comparatorCallback($accessorCallback($value[1], $value[0]));

                                foreach ($seen as $item) {
                                    if (true === $comparator($accessorCallback($item[1], $item[0]))) {
                                        $isSeen = true;

                                        break;
                                    }
                                }

                                if (false === $isSeen) {
                                    $seen[] = $value;
                                }

                                return $seen;
                            };

                    /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = Pipe::of()(
                        Pack::of(),
                        FoldLeft::of()($foldLeftCallbackBuilder($accessorCallback)($comparatorCallback))([]),
                        Unwrap::of(),
                        Unpack::of()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}

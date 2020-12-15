<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Contains extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static fn (...$values): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int, bool>
                 */
                static function (Iterator $iterator) use ($values): Generator {
                    // We could use something like:
                    // yield count($values) === Intersect::of()(...$values)($iterator);
                    // But it would not be very optimal because it would have to traverse
                    // the whole iterator.
                    foreach ($iterator as $value) {
                        foreach ($values as $k => $v) {
                            if ($v === $value) {
                                unset($values[$k]);
                            }

                            if ([] === $values) {
                                return yield true;
                            }
                        }
                    }

                    return yield false;
                };
    }
}

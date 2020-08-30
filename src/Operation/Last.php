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
final class Last extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (?callable $callback = null): Closure {
            return static function (int $size) use ($callback): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callback, $size): Generator {
                        $defaultCallback =
                            /**
                             * @param mixed $value
                             * @param mixed $key
                             * @psalm-param T $value
                             * @psalm-param TKey $key
                             * @psalm-param Iterator<TKey, T> $iterator
                             */
                            static function ($value, $key, Iterator $iterator): bool {
                                return true;
                            };

                        $callback = $callback ?? $defaultCallback;

                        return yield from Compose::of()(
                            Filter::of()($callback),
                            Reverse::of(),
                            Limit::of()($size)(0)
                        )($iterator);
                    };
            };
        };
    }
}

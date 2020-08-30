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
final class Get extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param array-key $keyToGet
             *
             * @param mixed $keyToGet
             */
            static function ($keyToGet): Closure {
                return
                    /**
                     * @psalm-param T $default
                     *
                     * @param mixed $default
                     */
                    static function ($default) use ($keyToGet): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<int, T>
                             */
                            static function (Iterator $iterator) use ($keyToGet, $default): Generator {
                                foreach ($iterator as $key => $value) {
                                    if ($key === $keyToGet) {
                                        return yield $value;
                                    }
                                }

                                return yield $default;
                            };
                    };
            };
    }
}

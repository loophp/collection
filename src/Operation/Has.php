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
final class Has extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(TKey, T): T): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(TKey, T): T $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, bool>
                     */
                    static function (Iterator $iterator) use ($callback): Generator {
                        foreach ($iterator as $key => $value) {
                            if ($callback($key, $value) === $value) {
                                return yield true;
                            }
                        }

                        return yield false;
                    };
            };
    }
}

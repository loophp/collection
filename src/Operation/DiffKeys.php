<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class DiffKeys extends AbstractOperation
{
    /**
     * @psalm-return Closure(TKey...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$values
             */
            static function (...$values): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     */
                    static function (Iterator $iterator) use ($values): Generator {
                        foreach ($iterator as $key => $value) {
                            if (false === in_array($key, $values, true)) {
                                yield $key => $value;
                            }
                        }
                    };
            };
    }
}

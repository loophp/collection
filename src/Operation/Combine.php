<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;

use const E_USER_WARNING;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Combine extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(Iterator<TKey, T>): Generator<T, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$keys
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<T, T>
             */
            static function (...$keys): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-retur Generator<T, T>
                     */
                    static function (Iterator $iterator) use ($keys): Generator {
                        $keys = new ArrayIterator($keys);

                        while ($iterator->valid() && $keys->valid()) {
                            yield $keys->current() => $iterator->current();

                            $iterator->next();
                            $keys->next();
                        }

                        if ($iterator->valid() !== $keys->valid()) {
                            trigger_error('Both keys and values must have the same amount of items.', E_USER_WARNING);
                        }
                    };
            };
    }
}

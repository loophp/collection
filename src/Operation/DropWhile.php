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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class DropWhile extends AbstractOperation
{
    /**
     * @psalm-return Closure((callable(T, TKey, Iterator<TKey, T>): bool)): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>):bool $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (callable $callback): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callback): Generator {
                        for (; $iterator->valid(); $iterator->next()) {
                            if (true === $callback($iterator->current(), $iterator->key(), $iterator)) {
                                continue;
                            }

                            break;
                        }

                        for (; $iterator->valid(); $iterator->next()) {
                            yield $iterator->key() => $iterator->current();
                        }
                    };
            };
    }
}

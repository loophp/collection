<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
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
final class Implode extends AbstractOperation
{
    /**
     * @psalm-return Closure(string): Closure(Iterator<TKey, T>): Generator<int, string>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, string>
             */
            static function (string $glue): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, string>
                     */
                    static function (Iterator $iterator) use ($glue): Generator {
                        $reducerFactory = static function (string $glue): Closure {
                            return
                                /**
                                 * @psalm-param TKey $key
                                 *
                                 * @param mixed $key
                                 */
                                static function (string $carry, string $item, $key, CachingIterator $iterator) use ($glue): string {
                                    $carry .= $item;

                                    if ($iterator->hasNext()) {
                                        $carry .= $glue;
                                    }

                                    return $carry;
                                };
                        };

                        return yield from FoldLeft::of()($reducerFactory($glue))('')(new CachingIterator($iterator));
                    };
            };
    }
}

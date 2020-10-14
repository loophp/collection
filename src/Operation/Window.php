<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function array_slice;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Window extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
             */
            static fn (int $size): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, list<T>>
                 */
                static function (Iterator $iterator) use ($size): Generator {
                    if (0 === $size) {
                        return yield from $iterator;
                    }

                    ++$size;
                    $size *= -1;

                    /** @psalm-var list<T> $stack */
                    $stack = [];

                    for (; $iterator->valid(); $iterator->next()) {
                        // @todo Should we use Pack ?
                        $stack[$iterator->key()] = $iterator->current();

                        yield $iterator->key() => array_slice($stack, $size);
                    }
                };
    }
}

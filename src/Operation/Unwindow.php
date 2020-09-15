<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Iterator\IterableIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Unwindow extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, list<T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, list<T>> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    /** @psalm-var Iterator<int, T> $lastIterator */
                    $lastIterator = Last::of()(new IterableIterator($value));

                    yield $key => $lastIterator->current();
                }
            };
    }
}

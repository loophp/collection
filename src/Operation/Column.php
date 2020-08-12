<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Column extends AbstractLazyOperation implements LazyOperation
{
    /**
     * Column constructor.
     *
     * @param int|string $column
     * @psalm-param array-key $column
     */
    public function __construct($column)
    {
        $this->storage['column'] = $column;
    }

    /**
     * @return \Closure(\Iterator<TKey, T>, array-key):(\Generator<int, iterable<TKey, T>>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param array-key $column
             *
             * @psalm-return \Generator<int, iterable<TKey, T>>
             *
             * @param mixed $column
             */
            static function (Iterator $iterator, $column): Generator {
                /**
                 * @var array-key $key
                 * @var iterable<TKey, T> $value
                 */
                foreach ((new Run())()($iterator, new Transpose()) as $key => $value) {
                    if ($key === $column) {
                        return yield from $value;
                    }
                }
            };
    }
}

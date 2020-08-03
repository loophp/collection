<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Column extends AbstractOperation implements Operation
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
                foreach ((new Run(new Transpose()))($iterator) as $key => $value) {
                    if ($key === $column) {
                        return yield from $value;
                    }
                }
            };
    }
}

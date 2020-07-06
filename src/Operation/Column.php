<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @extends AbstractOperation<TKey, array<U, V>, \Generator<int, V>>
 * @implements Operation<TKey, array<U, V>, \Generator<int, V>>
 */
final class Column extends AbstractOperation implements Operation
{
    /**
     * @param U $column
     */
    public function __construct($column)
    {
        $this->storage['column'] = $column;
    }

    /**
     * @return Closure(\Iterator<TKey, array<U, V>>, U): Generator<int, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, array<U,V>> $collection
             * @param U $column
             *
             * @return Generator<int, V>
             */
            static function (Iterator $iterator, $column): Generator {
                /**
                 * @psalm-var U $key
                 * @psalm-var V $value
                 */
                foreach ((new Run(new Transpose()))($iterator) as $key => $value) {
                    if ($key === $column) {
                        return yield from $value;
                    }
                }
            };
    }
}

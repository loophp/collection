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
     * @psalm-return Closure(Iterator<TKey, T>, array-key):(Generator<int, iterable<TKey, T>>)
     */
    public function __invoke(): Closure
    {
        return static function ($column): Closure {
            return static function (Iterator $iterator) use ($column): Generator {
                /**
                 * @psalm-var array-key $key
                 * @psalm-var iterable<TKey, T> $value
                 */
                foreach ((new Run())()((new Transpose())())($iterator) as $key => $value) {
                    if ($key === $column) {
                        return yield from $value;
                    }
                }
            };
        };
    }
}

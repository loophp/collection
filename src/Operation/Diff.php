<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Diff extends AbstractOperation implements Operation
{
    /**
     * @param U ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = $values;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param list<U> $values
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, $values): Generator {
                foreach ($iterator as $key => $value) {
                    if (false === in_array($value, $values, true)) {
                        yield $key => $value;
                    }
                }
            };
    }
}

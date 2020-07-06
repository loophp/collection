<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\SortableIterableIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Sort extends AbstractOperation implements Operation
{
    public function __construct(?callable $callback = null)
    {
        $this->storage['callback'] = $callback ?? Closure::fromCallable([$this, 'compare']);
    }

    /**
     * @return Closure(\Iterator<TKey, T>, callable(T, T):(int)): Generator<TKey, \ArrayIterator>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Generator<TKey, ArrayIterator>
             */
            static function (Iterator $iterator, callable $callback): Generator {
                return yield from new SortableIterableIterator($iterator, $callback);
            };
    }

    /**
     * @param T $left
     * @param T $right
     */
    private function compare($left, $right): int
    {
        return $left <=> $right;
    }
}

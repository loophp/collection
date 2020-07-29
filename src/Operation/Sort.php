<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\SortableIterableIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
final class Sort extends AbstractOperation implements Operation
{
    public function __construct(?callable $callback = null)
    {
        $this->storage['callback'] = $callback ?? Closure::fromCallable([$this, 'compare']);
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param callable(T, T):(int) $callback
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, callable $callback): Generator {
                return yield from (new SortableIterableIterator($iterator, $callback));
            };
    }

    /**
     * @param mixed $left
     * @psalm-param T $left
     *
     * @param mixed $right
     * @psalm-param T $right
     */
    private function compare($left, $right): int
    {
        return $left <=> $right;
    }
}

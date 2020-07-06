<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Prepend extends AbstractOperation implements Operation
{
    /**
     * Prepend constructor.
     *
     * @param U ...$items
     */
    public function __construct(...$items)
    {
        $this->storage['items'] = $items;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, array<int, U>):Generator<TKey|int, T|U>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<int, U> $items
             *
             * @return Generator<int|TKey, T|U>
             */
            static function (Iterator $iterator, array $items): Generator {
                foreach ($items as $key => $item) {
                    yield $key => $item;
                }

                foreach ($iterator as $key => $value) {
                    yield $key => $value;
                }
            };
    }
}

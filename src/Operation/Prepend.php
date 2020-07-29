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
 */
final class Prepend extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$items
     * @psalm-param T ...$items
     */
    public function __construct(...$items)
    {
        $this->storage['items'] = $items;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<T> $items
             *
             * @psalm-return \Generator<TKey|int, T>
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

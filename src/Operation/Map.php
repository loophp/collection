<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
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
final class Map extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = new ArrayIterator($callbacks);
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey):(T)> $callbacks
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, ArrayIterator $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    $callback = static function ($carry, callable $callback) use ($value, $key) {
                        return $callback($value, $key);
                    };

                    yield $key => (new Run())()($callbacks, new FoldLeft($callback, $value));
                }
            };
    }
}

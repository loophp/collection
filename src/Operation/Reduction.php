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
final class Reduction extends AbstractLazyOperation implements LazyOperation
{
    /**
     * @param mixed|null $initial
     * @psalm-param T|null $initial
     * @psalm-param callable(T|null, T, TKey):(T|null) $callback
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->storage = [
            'callback' => $callback,
            'initial' => $initial,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param callable(T|null, T, TKey):(T|null) $callback
             *
             * @param mixed $initial
             * @psalm-param T|null $initial
             *
             * @psalm-return \Generator<TKey, T|null>
             */
            static function (Iterator $iterator, callable $callback, $initial): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => ($initial = $callback($initial, $value, $key));
                }
            };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Reduction extends AbstractOperation implements Operation
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
             * @psalm-param callable(T|null, T, TKey):(T|null) $callable
             *
             * @param mixed $initial
             * @psalm-param T|null $initial
             *
             * @psalm-return \Generator<int, T|null>
             */
            static function (Iterator $iterator, callable $callback, $initial): Generator {
                foreach ($iterator as $key => $value) {
                    yield $initial = $callback($initial, $value, $key);
                }
            };
    }
}

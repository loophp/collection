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
 * @template V
 * @template W
 * @extends AbstractOperation<TKey, T, Generator<int, W>>
 * @implements Operation<TKey, T, Generator<int, W>>
 */
final class Iterate extends AbstractOperation implements Operation
{
    /**
     * Iterate constructor.
     *
     * @param callable(V|W): W $callback
     * @param list<V> $parameters
     */
    public function __construct(callable $callback, array $parameters = [])
    {
        $this->storage = [
            'callback' => $callback,
            'parameters' => $parameters,
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, callable(V|W):W, list<V>): Generator<int, W>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<mixed, mixed> $parameters
             *
             * @return Generator<int, W>
             */
            static function (Iterator $iterator, callable $callback, array $parameters): Generator {
                while (true) {
                    /** @psalm-var iterable<int, V|W> $parameters */
                    $parameters = array_values((array) $parameters);

                    yield $parameters = $callback(...$parameters);
                }
            };
    }
}

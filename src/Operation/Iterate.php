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
 *
 * @implements Operation<TKey, T>
 */
final class Iterate extends AbstractGeneratorOperation implements Operation
{
    /**
     * @param array<mixed, mixed> $parameters
     * @psalm-param array<array-key, T> $parameters
     *
     * @psalm-param callable(...list<T>):(array<array-key, T>) $callback
     */
    public function __construct(callable $callback, array $parameters = [])
    {
        $this->storage = [
            'callback' => $callback,
            'parameters' => $parameters,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-param callable(...list<T>):(array<array-key, T>) $callback
             *
             * @param array<int, mixed> $parameters
             * @psalm-param array<array-key, T> $parameters
             */
            static function (Iterator $iterator, callable $callback, array $parameters): Generator {
                while (true) {
                    yield $parameters = $callback(...array_values((array) $parameters));
                }
            };
    }
}

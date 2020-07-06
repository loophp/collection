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
 * @extends AbstractOperation<TKey, T, Generator<int, V>>
 * @implements Operation<TKey, T, Generator<int, V>>
 */
final class Reduction extends AbstractOperation implements Operation
{
    /**
     * Reduction constructor.
     *
     * @param callable(U|V, T, TKey): V $callback
     * @param U|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->storage = [
            'callback' => $callback,
            'initial' => $initial,
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, callable(U|V, T, TKey): V, U): \Generator<int, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U|null $initial
             *
             * @return \Generator<int, V, mixed, void>
             */
            static function (Iterator $iterator, callable $callback, $initial): Generator {
                foreach ($iterator as $key => $value) {
                    yield $initial = $callback($initial, $value, $key);
                }
            };
    }
}

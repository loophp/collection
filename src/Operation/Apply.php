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
 * @extends AbstractOperation<TKey, T, array<int, callable(T, TKey): (U|bool)>>
 * @implements Operation<TKey, T, array<int, callable(T, TKey): (U|bool)>>
 */
final class Apply extends AbstractOperation implements Operation
{
    /**
     * @param callable(T, TKey): (U|bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    /**
     * @return \Closure(\Iterator<TKey, T>, array<int, callable(T, TKey):(U|bool)>): \Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<int, callable(T, TKey): (U|bool)> $callbacks
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    foreach ($callbacks as $callback) {
                        if (true === $callback($value, $key)) {
                            continue;
                        }

                        break;
                    }

                    yield $key => $value;
                }
            };
    }
}

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
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Until extends AbstractOperation implements Operation
{
    /**
     * Until constructor.
     *
     * @param callable(T, TKey): (bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, array<int, callable(T, TKey): (bool)>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, callable(T, TKey): (int)> $callbacks
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => $value;

                    $result = array_reduce(
                        $callbacks,
                        /**
                         * @param callable(T, TKey): (int) $callable
                         */
                        static function (bool $carry, callable $callable) use ($key, $value): bool {
                            return ($callable($value, $key)) ?
                                $carry :
                                false;
                        },
                        true
                    );

                    if (true === $result) {
                        break;
                    }
                }
            };
    }
}

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
final class Since extends AbstractOperation implements Operation
{
    /**
     * Since constructor.
     *
     * @param callable(T, TKey): (bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, array<int, callable(T, TKey): (int)>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<int, callable(T, TKey): (int)> $callbacks
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                while ($iterator->valid()) {
                    $result = array_reduce(
                        $callbacks,
                        /**
                         * @param callable(T, TKey): (int) $callable
                         */
                        static function (bool $carry, callable $callable) use ($iterator): bool {
                            return ($callable($iterator->current(), $iterator->key())) ?
                                $carry :
                                false;
                        },
                        true
                    );

                    if (true === $result) {
                        break;
                    }

                    $iterator->next();
                }

                for (; $iterator->valid(); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            };
    }
}

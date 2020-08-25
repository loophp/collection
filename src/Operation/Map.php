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
final class Map extends AbstractOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey): T> $callbacks
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    $callback =
                        /**
                         * @param mixed $carry
                         * @psalm-param T $carry
                         * @psalm-param callable(T, TKey): T $callback
                         * @psalm-return T
                         */
                        static function ($carry, callable $callback) use ($value, $key) {
                            return $callback($value, $key);
                        };

                    yield $key => array_reduce($callbacks, $callback, $value);
                }
            };
    }
}

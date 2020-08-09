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
final class Walk extends AbstractGeneratorOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
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
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    // Custom array_reduce function with the key passed in argument.
                    foreach ($callbacks as $callback) {
                        $value = $callback($value, $key);
                    }

                    yield $key => $value;
                }
            };
    }
}

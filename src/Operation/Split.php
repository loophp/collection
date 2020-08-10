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
final class Split extends AbstractGeneratorOperation implements Operation
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
             * @psalm-param list<callable(T, TKey):(bool)> $callbacks
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                $carry = [];

                foreach ($iterator as $key => $value) {
                    $callbackReturn = array_reduce(
                        $callbacks,
                        static function ($carry, callable $callback) use ($key, $value): bool {
                            // @todo : Do this everywhere.
                            return $callback($value, $key) !== $carry;
                        },
                        true
                    );

                    $carry[] = $value;

                    if (true === $callbackReturn) {
                        continue;
                    }

                    yield $carry;

                    $carry = [];
                }

                if ([] !== $carry) {
                    yield $carry;
                }
            };
    }
}

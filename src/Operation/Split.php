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
final class Split extends AbstractOperation implements Operation
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
             * @psalm-param list<callable(T, TKey):(bool)> $callbacks
             *
             * @psalm-return Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                $carry = [];

                foreach ($iterator as $key => $value) {
                    $callbackReturn = array_reduce(
                        $callbacks,
                        static function (bool $carry, callable $callback) use ($key, $value): bool {
                            return $callback($value, $key) !== $carry;
                        },
                        false
                    );

                    if (true === $callbackReturn && [] !== $carry) {
                        yield $carry;

                        $carry = [];
                    }

                    $carry[] = $value;
                }

                if ([] !== $carry) {
                    yield $carry;
                }
            };
    }
}

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
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey):(bool)> $callbacks
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                $carry = [];

                foreach ($iterator as $key => $value) {
                    $carry[] = $value;

                    foreach ($callbacks as $callback) {
                        if (true !== $callback($value, $key)) {
                            continue;
                        }

                        yield $carry;

                        $carry = [];
                    }
                }

                if ([] !== $carry) {
                    yield $carry;
                }
            };
    }
}

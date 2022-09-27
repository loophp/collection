<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Flatten extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(iterable<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<mixed, mixed>
             */
            static fn (int $depth): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 */
                static function (iterable $iterable) use ($depth): Generator {
                    foreach ($iterable as $key => $value) {
                        if (!is_iterable($value)) {
                            yield $key => $value;

                            continue;
                        }

                        yield from (1 !== $depth)
                            ? (new Flatten())()($depth - 1)($value)
                            : $value;
                    }
                };
    }
}

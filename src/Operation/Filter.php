<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Filter extends AbstractOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $defaultCallback =
            /**
             * @param mixed $item
             * @psalm-param T $item
             */
            static function ($item): bool {
                return (bool) $item;
            };

        $this->storage['callbacks'] = [] === $callbacks ?
            [$defaultCallback] :
            $callbacks;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey, \Iterator<TKey, T>):(bool)> $callbacks
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                yield from array_reduce(
                    $callbacks,
                    static function (Iterator $carry, callable $callback): CallbackFilterIterator {
                        return new CallbackFilterIterator($carry, $callback);
                    },
                    $iterator
                );
            };
    }
}

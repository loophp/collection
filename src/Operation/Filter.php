<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Filter extends AbstractOperation implements Operation
{
    /**
     * @param callable(T, TKey, \Iterator<TKey, T>): (bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $defaultCallback =
            /**
             * @param T $item
             */
            static function ($item): bool {
                return true === (bool) $item;
            };

        $this->storage['callbacks'] = [] === $callbacks ?
            [$defaultCallback] :
            $callbacks;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<callable(T, TKey, \Iterator):(bool)>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param list<callable(T, TKey, \Iterator): bool> $callbacks
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($callbacks as $callback) {
                    /** @psalm-var \Iterator<TKey, T> $iterator */
                    $iterator = new CallbackFilterIterator($iterator, $callback);
                }

                return yield from $iterator;
            };
    }
}

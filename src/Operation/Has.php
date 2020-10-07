<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Has extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(TKey, T): T): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(TKey, T): T $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (callable $callback): Closure {
                $mapCallback =
                    /**
                     * @param mixed $value
                     * @psalm-param T $value
                     *
                     * @param mixed $key
                     * @psalm-param TKey $key
                     */
                    static function ($value, $key) use ($callback): bool {
                        return $callback($key, $value) === $value;
                    };

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
                $pipe = Pipe::of()(
                    Map::of()($mapCallback),
                    Append::of()(false),
                    Head::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}

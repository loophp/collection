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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class DropWhile extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey , Iterator<TKey, T> ): bool):Closure (Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>):bool $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure => static function (Iterator $iterator) use ($callbacks): Generator {
                $break = false;

                foreach ($iterator as $key => $current) {
                    if (false === $break) {
                        $reduced = array_reduce(
                            $callbacks,
                            static fn (bool $carry, callable $callback): bool => ($callback($current, $key, $iterator)) ?
                                $carry :
                                false,
                            true
                        );

                        if (true === $reduced) {
                            continue;
                        }

                        $break = true;
                    }

                    yield $key => $current;
                }
            };
    }
}

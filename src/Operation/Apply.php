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
final class Apply extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey, Iterator<TKey, T>):bool ...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>):bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    foreach ($iterator as $key => $value) {
                        foreach ($callbacks as $cKey => $callback) {
                            $result = $callback($value, $key, $iterator);

                            if (false === $result) {
                                unset($callbacks[$cKey]);
                            }
                        }

                        yield $key => $value;
                    }
                };
    }
}

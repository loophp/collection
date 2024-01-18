<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Stringable;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Implode extends AbstractOperation
{
    /**
     * @return Closure(string): Closure(iterable<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<TKey, string>
             */
            static function (string $glue): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<TKey, string> $pipe */
                $pipe = (new Pipe())()(
                    (new Intersperse())()($glue)(1)(0),
                    (new Limit())()(-1)(1),
                    (new Reduce())()(
                        static fn (string $carry, string|Stringable $item): string => $carry .= (string) $item
                    )('')
                );

                // Point free style.
                return $pipe;
            };
    }
}

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
final class Implode extends AbstractOperation
{
    /**
     * @psalm-return Closure(string): Closure(Iterator<TKey, T>): Generator<int, string>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, string>
             */
            static function (string $glue): Closure {
                $reducer =
                    /**
                     * @param string $item
                     * @psalm-param T|string $item
                     */
                    static fn (string $carry, $item): string => $carry .= $item;

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, string> $pipe */
                $pipe = Pipe::of()(
                    Intersperse::of()($glue)(1)(0),
                    Drop::of()(1),
                    FoldLeft::of()($reducer)('')
                );

                // Point free style.
                return $pipe;
            };
    }
}

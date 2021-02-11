<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use const PHP_EOL;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Lines extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, (T | string)>):Generator<int, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @psalm-param T $value
             */
            static fn (array $value): string => implode('', $value);

        /** @psalm-var Closure(Iterator<TKey, (T | string)>):Generator<int, string> $pipe */
        $pipe = Pipe::of()(
            Explode::of()(PHP_EOL, "\n", "\r\n"),
            Map::of()($mapCallback)
        );

        // Point free style.
        return $pipe;
    }
}

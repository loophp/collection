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
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Lines extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, (T | string)>):Generator<int, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback = static fn (array $value): string => implode('', $value);

        /** @psalm-var Closure(Iterator<TKey, (T | string)>):Generator<int, string> $pipe */
        $pipe = Pipe::of()(
            Explode::of()(PHP_EOL, "\n", "\r\n"),
            Map::of()($mapCallback)
        );

        // Point free style.
        return $pipe;
    }
}

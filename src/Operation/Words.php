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
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Words extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback = static function (array $value): string {
            return implode('', $value);
        };

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, string> $pipe */
        $pipe = Pipe::of()(
            Explode::of()("\t", "\n", ' '),
            Map::of()($mapCallback),
            Compact::of()()
        );

        // Point free style.
        return $pipe;
    }
}

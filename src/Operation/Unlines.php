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
final class Unlines extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, (T|string)>): Generator<TKey, T|string, mixed, void>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, (T|string)>):Generator<TKey, T|string> $implode */
        $implode = Implode::of()(PHP_EOL);

        // Point free style.
        return $implode;
    }
}

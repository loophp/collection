<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Words extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<TKey, string> $pipe */
        $pipe = (new Pipe())()(
            (new Explode())()("\t", "\n", ' '),
            (new Map())()(
                /**
                 * @param list<string> $value
                 */
                static fn (array $value): string => implode('', $value)
            ),
            (new Compact())()()
        );

        // Point free style.
        return $pipe;
    }
}

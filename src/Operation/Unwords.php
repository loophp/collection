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
final class Unwords extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, (T|string)>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        return (new Implode())()(' ');
    }
}

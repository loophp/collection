<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Head extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): (Generator<TKey, T>)
     */
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            return yield $iterator->key() => $iterator->current();
        };
    }
}

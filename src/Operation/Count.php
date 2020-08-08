<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Count extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $collection): int {
            return iterator_count($collection);
        };
    }
}

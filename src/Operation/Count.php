<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\EagerOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements EagerOperation<TKey, T>
 */
final class Count extends AbstractEagerOperation implements EagerOperation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $collection): int {
            return iterator_count($collection);
        };
    }
}

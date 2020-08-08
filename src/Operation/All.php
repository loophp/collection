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
final class All extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $collection): array {
            return iterator_to_array($collection);
        };
    }
}

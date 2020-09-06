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
 */
final class First extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            if (!$iterator->valid()) {
                return yield from [];
            }

            return yield $iterator->key() => $iterator->current();
        };
    }
}

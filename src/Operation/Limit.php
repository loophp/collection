<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Limit extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $limit): Closure {
            return static function (int $offset = 0) use ($limit): Closure {
                return static function (Iterator $iterator) use ($limit, $offset): Generator {
                    if (0 === $limit) {
                        return yield from [];
                    }

                    return yield from new LimitIterator($iterator, $offset, $limit);
                };
            };
        };
    }
}

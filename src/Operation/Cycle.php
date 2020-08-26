<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Cycle extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $length): Closure {
            return static function (Iterator $iterator) use ($length): Generator {
                if (0 === $length) {
                    return yield from [];
                }

                return yield from new LimitIterator(
                    new InfiniteIterator($iterator),
                    0,
                    $length
                );
            };
        };
    }
}

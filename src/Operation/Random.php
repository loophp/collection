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
 */
final class Random extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $size): Closure {
            return static function (Iterator $iterator) use ($size): Generator {
                return yield from (Compose::of()(
                    Limit::of()($size)(0),
                    Shuffle::of()
                )($iterator));
            };
        };
    }
}

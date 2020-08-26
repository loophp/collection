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
final class Skip extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int ...$skip): Closure {
            return static function (Iterator $iterator) use ($skip): Generator {
                $skip = array_sum($skip);

                foreach ($iterator as $key => $value) {
                    if (0 < $skip--) {
                        continue;
                    }

                    yield $key => $value;
                }
            };
        };
    }
}

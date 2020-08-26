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
final class Nth extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $step): Closure {
            return static function (int $offset) use ($step): Closure {
                return static function (Iterator $iterator) use ($step, $offset): Generator {
                    $position = 0;

                    foreach ($iterator as $key => $value) {
                        if ($position++ % $step !== $offset) {
                            continue;
                        }

                        yield $key => $value;
                    }
                };
            };
        };
    }
}

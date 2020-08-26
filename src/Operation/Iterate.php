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
final class Iterate extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (callable $callback): Closure {
            return static function (...$parameters) use ($callback): Closure {
                return static function (Iterator $iterator) use ($callback, $parameters): Generator {
                    while (true) {
                        yield current(
                            $parameters = (array) $callback(...array_values((array) $parameters))
                        );
                    }
                };
            };
        };
    }
}

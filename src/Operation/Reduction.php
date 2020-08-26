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
final class Reduction extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (callable $callback): Closure {
            return static function ($initial = null) use ($callback): Closure {
                return static function (Iterator $iterator) use ($callback, $initial): Generator {
                    foreach ($iterator as $key => $value) {
                        yield $key => ($initial = $callback($initial, $value, $key));
                    }
                };
            };
        };
    }
}

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
 */
final class Reduce extends AbstractOperation implements Operation
{
    /**
     * @psalm-param \Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|scalar|null|\Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return static function (callable $callback): Closure {
            return static function ($initial = null) use ($callback): Closure {
                return static function (Iterator $iterator) use ($callback, $initial) {
                    return yield from FoldLeft::of()($callback)($initial)($iterator);
                };
            };
        };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Unwrap extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<int, array<TKey, T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            foreach ($iterator as $value) {
                foreach ((array) $value as $k => $v) {
                    yield $k => $v;
                }
            }
        };
    }
}

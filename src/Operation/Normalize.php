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
 * @extends AbstractOperation<TKey, T, Generator<int, T>>
 * @implements Operation<TKey, T, Generator<int, T>>
 */
final class Normalize extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Generator<int, T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $value) {
                    yield $value;
                }
            };
    }
}

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
 * @extends AbstractOperation<TKey, T, Generator<string, T>>
 * @implements Operation<TKey, T, Generator<string, T>>
 */
final class Flip extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): \Generator<string, TKey>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<string, TKey>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    yield (string) $value => $key;
                }
            };
    }
}

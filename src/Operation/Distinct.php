<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Distinct extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                $seen = [];

                foreach ($iterator as $key => $value) {
                    if (true === in_array($value, $seen, true)) {
                        continue;
                    }

                    $seen[] = $value;

                    yield $key => $value;
                }
            };
    }
}

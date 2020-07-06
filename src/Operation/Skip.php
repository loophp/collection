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
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Skip extends AbstractOperation implements Operation
{
    public function __construct(int ...$skip)
    {
        $this->storage['skip'] = $skip;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, array<int, int>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, int> $skip
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $skip): Generator {
                $skip = array_sum($skip);

                foreach ($iterator as $key => $value) {
                    if (0 < $skip--) {
                        continue;
                    }

                    yield $key => $value;
                }
            };
    }
}

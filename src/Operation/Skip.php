<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Skip extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(int ...$skip)
    {
        $this->storage['skip'] = $skip;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<int> $skip
             *
             * @psalm-return \Generator<TKey, T>
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

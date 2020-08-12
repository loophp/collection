<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Distinct extends AbstractLazyOperation implements LazyOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                $seen = [];

                foreach ($iterator as $key => $value) {
                    if (false !== in_array($value, $seen, true)) {
                        continue;
                    }

                    $seen[] = $value;

                    yield $key => $value;
                }
            };
    }
}

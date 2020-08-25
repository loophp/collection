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
final class Wrap extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int, array<TKey, T>>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    yield [$key => $value];
                }
            };
    }
}

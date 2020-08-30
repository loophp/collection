<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template T
 * @psalm-template T of array-key
 */
final class Flip extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int|string, TKey>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    yield $value => $key;
                }
            };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Nullsy extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-return Generator<int, bool>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $value) {
                    if (null !== $value) {
                        return yield false;
                    }
                }

                return yield true;
            };
    }
}

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
final class Truthy extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-return Generator<int, bool> $iterator
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    if (false === (bool) $value) {
                        return yield false;
                    }
                }

                return yield true;
            };
    }
}

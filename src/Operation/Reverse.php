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
 *
 * @implements Operation<TKey, T>
 */
final class Reverse extends AbstractGeneratorOperation implements Operation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey|null, T, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var array<TKey, T> $all */
                $all = iterator_to_array((new Run())()($iterator, new Wrap()));

                for (end($all); null !== key($all); prev($all)) {
                    $item = current($all);

                    yield key($item) => current($item);
                }
            };
    }
}

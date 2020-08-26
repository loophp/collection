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
final class Reverse extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var Generator<int, array{0: TKey, 1: T}> $pack */
                $pack = Pack::of()($iterator);
                $all = iterator_to_array($pack);

                for (end($all); null !== key($all); prev($all)) {
                    $item = current($all);

                    yield $item[0] => $item[1];
                }
            };
    }
}

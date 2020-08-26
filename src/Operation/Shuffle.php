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
final class Shuffle extends AbstractOperation implements Operation
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
                /** @psalm-var Iterator<int, array{0: TKey, 1: T}> $pack */
                $pack = Pack::of()($iterator);
                $data = iterator_to_array($pack);

                while ([] !== $data) {
                    $randomKey = array_rand($data);

                    yield $data[$randomKey][0] => $data[$randomKey][1];

                    unset($data[$randomKey]);
                }
            };
    }
}

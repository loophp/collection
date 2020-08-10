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
final class Shuffle extends AbstractGeneratorOperation implements Operation
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
                /** @psalm-var array<TKey, T>  $data */
                $data = iterator_to_array((new Run(new Wrap()))()($iterator));

                while ([] !== $data) {
                    $randomKey = array_rand($data);

                    yield key($data[$randomKey]) => current($data[$randomKey]);

                    unset($data[$randomKey]);
                }
            };
    }
}

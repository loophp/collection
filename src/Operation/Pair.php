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
final class Pair extends AbstractGeneratorOperation implements Operation
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
                /** @psalm-var list<int, list<T|TKey>> $chunk */
                foreach ((new Run(new Chunk(2)))()($iterator) as $chunk) {
                    /** @psalm-var array{TKey, T} $chunk */
                    $chunk = array_values($chunk);

                    yield $chunk[0] => $chunk[1];
                }
            };
    }
}

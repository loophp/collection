<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Unpack extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<int, array{0:TKey, 1:T}|T> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $key => $value) {
                    if (!is_iterable($value)) {
                        continue;
                    }

                    /** @psalm-var array<int, array<TKey, T>> $chunks */
                    $chunks = (new Run((new Chunk(2))))(new IterableIterator($value));

                    foreach ($chunks as [$k, $v]) {
                        yield $k => $v;
                    }
                }
            };
    }
}

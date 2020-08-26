<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Pair extends AbstractOperation extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<T, T>
             */
            static function (Iterator $iterator): Generator {
                $chunk = (new Chunk())()(2);

                /** @psalm-var list<T> $chunk */
                foreach ((new Run())()($chunk)($iterator) as $chunk) {
                    $chunk = array_values($chunk);

                    yield $chunk[0] => $chunk[1];
                }
            };
    }
}

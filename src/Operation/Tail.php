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
final class Tail extends AbstractGeneratorOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 1;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<Tkey, T>
             */
            static function (Iterator $iterator, int $length): Generator {
                return yield from (
                new Run(
                    (new Skip(iterator_count($iterator) - $length)),
                    new Limit($length)
                ))()($iterator);
            };
    }
}

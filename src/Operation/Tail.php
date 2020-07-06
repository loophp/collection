<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Tail extends AbstractOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 1;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, int): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, int $length): Generator {
                return yield from (
                new Run(
                    new Limit($length)
                ))(
                    (new Run(new Skip(iterator_count($iterator) - $length)))($iterator)
                );
            };
    }
}

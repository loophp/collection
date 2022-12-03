<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Tails extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, list<T>, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, list<T>, mixed, void>
             */
            static function (iterable $iterable): Generator {
                /** @var Generator<int, array{0: TKey, 1: T}> $generator */
                $generator = (new Pack())()($iterable);
                $data = [...$generator];

                while ([] !== $data) {
                    /** @psalm-suppress InvalidOperand */
                    yield [...(new Unpack())()($data)];

                    array_shift($data);
                }

                yield [];
            };
    }
}

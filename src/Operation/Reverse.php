<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Reverse extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var Generator<int, array{0: TKey, 1: T}> $iterator */
                $iterator = Pack::of()($iterator);
                /** @psalm-var Generator<int, array{0: array{0: TKey, 1: T}}> $iterator */
                $iterator = Wrap::of()($iterator);

                /**
                 * @param array $carry
                 * @psalm-param array<int, array{0: TKey, 1: T}> $carry
                 *
                 * @param array $value
                 * @psalm-param array{0: TKey, 1: T} $value
                 *
                 * @psalm-return array<int, array{0: TKey, 1: T}>
                 */
                $callback = static function (array $carry, array $value): array {
                    array_unshift($carry, ...$value);

                    return $carry;
                };

                if (!$iterator->valid()) {
                    return yield from [];
                }

                /** @psalm-var Iterator<int, array{0: TKey, 1: T}> $foldLeft1 */
                $foldLeft1 = FoldLeft1::of()($callback)($iterator);

                /** @psalm-var Iterator<TKey, T> $unpack */
                $unpack = Unpack::of()(new ArrayIterator($foldLeft1->current()));

                return yield from $unpack;
            };
    }
}

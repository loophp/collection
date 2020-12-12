<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

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
final class Unzip extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, list<T>>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        $reduceCallback =
            /**
             * @psalm-param array<int, list<T>> $carry
             * @psalm-param iterable<TKey, T> $value
             *
             * @psalm-return array<int, list<T>>
             */
            static function (array $carry, iterable $value): array {
                $index = 0;

                foreach ($value as $v) {
                    $carry[$index++][] = $v;
                }

                return $carry;
            };

        /** @psalm-var Closure(Iterator<TKey, list<T>>): Generator<int, list<T>> $pipe */
        $pipe = Pipe::of()(
            FoldLeft::of()($reduceCallback)([]),
            Unwrap::of()
        );

        // Point free style.
        return $pipe;
    }
}

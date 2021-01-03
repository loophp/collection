<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Distinct extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var list<T> $seen */
        $seen = [];

        $filterCallback =
            /**
             * @param mixed $value
             * @psalm-param T $value
             */
            static function ($value) use (&$seen): bool {
                $return = in_array($value, $seen, true);

                /** @psalm-var list<T> $seen */
                $seen[] = $value;

                return !$return;
            };

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
        $filter = Filter::of()($filterCallback);

        // Point free style.
        return $filter;
    }
}

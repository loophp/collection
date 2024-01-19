<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Exception;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\iterators\SortIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Sort extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(null|(Closure(T, T, TKey, TKey): int)): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(null|Closure(T, T, TKey, TKey): int): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (int $type = Operation\Sortable::BY_VALUES): Closure =>
                /**
                 * @param null|(Closure(T, T, TKey, TKey): int)|(callable(T, T, TKey, TKey): int) $callback
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static function (null|callable|Closure $callback = null) use ($type): Closure {
                    if (Operation\Sortable::BY_VALUES !== $type && Operation\Sortable::BY_KEYS !== $type) {
                        throw new Exception('Invalid sort type.');
                    }

                    $callback ??=
                        /**
                         * @param T $left
                         * @param T $right
                         * @param TKey $leftKey
                         * @param TKey $rightKey
                         */
                        static fn (mixed $left, mixed $right, mixed $leftKey, mixed $rightKey): int => $right <=> $left;

                    if (!($callback instanceof Closure)) {
                        trigger_deprecation(
                            'loophp/collection',
                            '7.4',
                            'Passing a callable as argument is deprecated and will be removed in 8.0. Use a closure instead.',
                            self::class
                        );

                        $callback = Closure::fromCallable($callback);
                    }

                    $operations = Operation\Sortable::BY_VALUES === $type ?
                        [
                            'before' => [],
                            'after' => [],
                        ] :
                        [
                            'before' => [(new Flip())()],
                            'after' => [(new Flip())()],
                        ];

                    $sortedIterator =
                        /**
                         * @param iterable<TKey, T> $iterable
                         *
                         * @return SortIterableAggregate<TKey, T>
                         */
                        static fn (iterable $iterable): SortIterableAggregate => new SortIterableAggregate($iterable, $callback);

                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $sort */
                    $sort = (new Pipe())()(
                        ...$operations['before'],
                        ...[$sortedIterator],
                        ...$operations['after']
                    );

                    // Point free style.
                    return $sort;
                };
    }
}

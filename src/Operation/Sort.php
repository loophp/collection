<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Exception;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Sort extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (int $type = Operation\Sortable::BY_VALUES): Closure {
            return static function (?callable $callback = null) use ($type): Closure {
                $callback = $callback ??
                    /**
                     * @param mixed $left
                     * @psalm-param T|TKey $left
                     *
                     * @param mixed $right
                     * @psalm-param T|TKey $right
                     */
                    static function ($left, $right): int {
                        return $left <=> $right;
                    };

                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     * @psalm-param callable(T, T):(int) $callback
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($type, $callback): Generator {
                        if (Operation\Sortable::BY_VALUES !== $type && Operation\Sortable::BY_KEYS !== $type) {
                            throw new Exception('Invalid sort type.');
                        }

                        $operations = Operation\Sortable::BY_VALUES === $type ?
                            [
                                'before' => [Pack::of()],
                                'after' => [Unpack::of()],
                            ] :
                            [
                                'before' => [Flip::of(), Pack::of()],
                                'after' => [Unpack::of(), Flip::of()],
                            ];

                        /** @psalm-var callable(Iterator<TKey, T>): Generator<int, array{0:TKey, 1:T}> | callable(Iterator<TKey, T>): Generator<int, array{0:T, 1:TKey}> $before */
                        $before = Compose::of()(...$operations['before']);

                        $arrayIterator = new ArrayIterator(iterator_to_array($before($iterator)));
                        $arrayIterator->uasort(
                            /**
                             * @psalm-param array{0:TKey|T, 1:T|TKey} $left
                             * @psalm-param array{0:TKey|T, 1:T|TKey} $right
                             */
                            static function (array $left, array $right) use ($callback): int {
                                return $callback($left[1], $right[1]);
                            }
                        );

                        return yield from Compose::of()(...$operations['after'])($arrayIterator);
                    };
            };
        };
    }
}

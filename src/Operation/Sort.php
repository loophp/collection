<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Exception;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Sort extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $type = Operation\Sortable::BY_VALUES): Closure {
            return static function (?callable $callback = null) use ($type): Closure {
                $callback = $callback ?? static function ($left, $right): int {
                    return $left <=> $right;
                };

                return
                    /**
                     * @psalm-param \Iterator<TKey, T> $iterator
                     * @psalm-param callable(T, T):(int) $callback
                     *
                     * @psalm-return \Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($type, $callback): Generator {
                        if (Operation\Sortable::BY_VALUES !== $type && Operation\Sortable::BY_KEYS !== $type) {
                            throw new Exception('Invalid sort type.');
                        }

                        $operations = Operation\Sortable::BY_VALUES === $type ?
                            [
                                'before' => [new Pack()],
                                'after' => [new Unpack()],
                            ] :
                            [
                                'before' => [new Flip(), new Pack()],
                                'after' => [new Unpack(), new Flip()],
                            ];

                        $callback =
                            /**
                             * @psalm-param array{0:TKey, 1:T} $left
                             * @psalm-param array{0:TKey, 1:T} $right
                             */
                            static function (array $left, array $right) use ($defaultCallback): int {
                                return $defaultCallback($left[1], $right[1]);
                            };

                        $arrayIterator = new ArrayIterator(iterator_to_array((new Run())()(...$operations['before'])($iterator)));
                        $arrayIterator->uasort($callback);

                        return yield from (
                            (new Run())()(...$operations['after'])($arrayIterator)
                        );
                    };
            };
        };
    }
}

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
    public function __construct(int $type = Operation\Sortable::BY_VALUES, ?callable $callback = null)
    {
        $this->storage = [
            'type' => $type,
            'callback' => $callback ?? Closure::fromCallable([$this, 'compare']),
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-param callable(T, T):(int) $callback
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator, int $type, callable $callback): Generator {
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
                    static function (array $left, array $right) use ($callback): int {
                        return $callback($left[1], $right[1]);
                    };

                $arrayIterator = new ArrayIterator(iterator_to_array((new Run(...$operations['before']))($iterator)));
                $arrayIterator->uasort($callback);

                return yield from (new Run(...$operations['after']))($arrayIterator);
            };
    }

    /**
     * @psalm-param T $left
     * @psalm-param T $right
     *
     * @param mixed $left
     * @param mixed $right
     */
    private function compare($left, $right): int
    {
        return $left <=> $right;
    }
}

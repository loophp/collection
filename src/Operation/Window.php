<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<int, list<T>>>
 * @implements Operation<TKey, T, \Generator<int, list<T>>>
 */
final class Window extends AbstractOperation implements Operation
{
    public function __construct(int ...$length)
    {
        $this->storage['length'] = $length;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<int>): Generator<int, array<array-key, T>, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, int> $length
             * @param Iterator<TKey, T> $iterator
             */
            static function (Iterator $iterator, array $length): Generator {
                /** @psalm-var \Iterator<int, int> $length */
                $length = new IterableIterator((new Run(new Loop()))($length));

                for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                    yield iterator_to_array((new Run(new Slice($i, $length->current())))($iterator));
                    $length->next();
                }
            };
    }
}

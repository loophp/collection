<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

final class Zip extends AbstractOperation implements Operation
{
    /**
     * Zip constructor.
     *
     * @param iterable<mixed> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->storage['iterables'] = $iterables;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, iterable> $iterables
             */
            static function (Iterator $iterator, array $iterables): Generator {
                $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
                $mit->attachIterator($iterator);

                foreach ($iterables as $iterableIterator) {
                    $mit->attachIterator(new IterableIterator($iterableIterator));
                }

                foreach ($mit as $values) {
                    yield $values;
                }
            };
    }
}

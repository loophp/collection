<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * Class Zip.
 */
final class Zip implements Operation
{
    /**
     * @var iterable[]
     */
    private $iterables;

    /**
     * Zip constructor.
     *
     * @param iterable ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->iterables = $iterables;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $iterables = $this->iterables;

        return static function () use ($iterables, $collection): Generator {
            $getIteratorCallback = static function ($iterable): IterableIterator {
                return new IterableIterator($iterable);
            };

            $items = array_merge([$collection], $iterables);

            $walk = new Walk($getIteratorCallback);
            $append = new Append(...$items);

            $iterators = new ClosureIterator(
                $walk->on(new ClosureIterator($append->on([])))
            );

            $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

            foreach ($iterators as $iterator) {
                $mit->attachIterator($iterator);
            }

            foreach ($mit as $values) {
                yield $values;
            }
        };
    }
}

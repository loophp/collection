<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
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
     * @param iterable<mixed> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->iterables = $iterables;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $iterables = $this->iterables;

        return static function (iterable $collection) use ($iterables): Generator {
            $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
            $mit->attachIterator(new IterableIterator($collection));

            foreach ($iterables as $iterator) {
                $mit->attachIterator(new IterableIterator($iterator));
            }

            foreach ($mit as $values) {
                yield $values;
            }
        };
    }
}

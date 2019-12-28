<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\IterableIterator;
use Generator;
use InfiniteIterator;
use LimitIterator;

/**
 * Class Cycle.
 */
final class Cycle implements Operation
{
    /**
     * @var int
     */
    private $length;

    /**
     * Cycle constructor.
     *
     * @param int $length
     */
    public function __construct(int $length = 0)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        return static function () use ($collection, $length): Generator {
            $cycleIterator = new LimitIterator(
                new InfiniteIterator(
                    new IterableIterator($collection)
                ),
                0,
                $length
            );

            foreach ($cycleIterator as $value) {
                yield $value;
            }
        };
    }
}

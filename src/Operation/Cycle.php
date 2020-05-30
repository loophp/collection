<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use LimitIterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

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
    public function __invoke(): Closure
    {
        $length = $this->length;

        return static function (iterable $collection) use ($length): Generator {
            $iterator = new LimitIterator(
                new InfiniteIterator(
                    new IterableIterator($collection)
                ),
                0,
                $length
            );

            foreach ($iterator as $value) {
                yield $value;
            }
        };
    }
}

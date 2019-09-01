<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Flatten.
 */
final class Flatten implements Operation
{
    /**
     * @var int
     */
    private $depth;

    /**
     * Flatten constructor.
     *
     * @param int $depth
     */
    public function __construct(int $depth)
    {
        $this->depth = $depth;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $depth = $this->depth;

        return static function () use ($depth, $collection): \Generator {
            foreach ($collection as $value) {
                if (false === \is_iterable($value)) {
                    yield $value;
                } elseif (1 === $depth) {
                    foreach ($value as $subValue) {
                        yield $subValue;
                    }
                } else {
                    $iterator = new ClosureIterator((new Flatten($depth - 1))->on($value));

                    foreach ($iterator as $subValue) {
                        yield $subValue;
                    }
                }
            }
        };
    }
}

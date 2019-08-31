<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Flatten.
 */
final class Flatten extends Operation
{
    /**
     * Flatten constructor.
     *
     * @param int $depth
     */
    public function __construct(int $depth)
    {
        parent::__construct(...[$depth]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$depth] = $this->parameters;

        return static function () use ($depth, $collection): \Generator {
            foreach ($collection as $value) {
                if ((false === \is_array($value)) && (false === ($value instanceof \Traversable))) {
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

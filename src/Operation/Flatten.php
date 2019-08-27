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
            foreach ($collection as $item) {
                if (!\is_array($item) && !$item instanceof \Traversable) {
                    yield $item;
                } elseif (1 === $depth) {
                    foreach ($item as $i) {
                        yield $i;
                    }
                } else {
                    $flatten = new Flatten($depth - 1);
                    $iterator = new ClosureIterator($flatten->on($item));

                    foreach ($iterator as $flattenItem) {
                        yield $flattenItem;
                    }
                }
            }
        };
    }
}

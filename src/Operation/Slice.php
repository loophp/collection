<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Slice.
 */
final class Slice extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$offset, $length] = $this->parameters;

        return static function () use ($offset, $length, $collection): \Generator {
            if (null === $length) {
                yield from (new Skip($offset))->on($collection)();
            } else {
                $limit = new Limit($length);
                $skip = new Skip($offset);

                yield from $limit->on(new ClosureIterator($skip->on($collection)))();
            }
        };
    }
}

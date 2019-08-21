<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Slice.
 */
final class Slice extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$offset, $length] = $this->parameters;

        return Collection::with(
            static function () use ($offset, $length, $collection): \Generator {
                if (null === $length) {
                    yield from $collection->skip($offset);
                } else {
                    yield from $collection->skip($offset)->limit($length);
                }
            }
        );
    }
}

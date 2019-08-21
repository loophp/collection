<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Chunk.
 */
final class Chunk extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        $size = $this->parameters[0];

        if (0 >= $size) {
            return Collection::empty();
        }

        return Collection::with(
            static function () use ($size, $collection): \Generator {
                /** @var \Iterator $iterator */
                $iterator = $collection->getIterator();

                while ($iterator->valid()) {
                    $values = [];

                    for ($i = 0; $iterator->valid() && $i < $size; $i++, $iterator->next()) {
                        $values[$iterator->key()] = $iterator->current();
                    }

                    yield Collection::with($values);
                }
            }
        );
    }
}

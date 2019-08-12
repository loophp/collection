<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Chunk.
 */
final class Chunk extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $size = $this->parameters[0];

        if (0 >= $size) {
            return $collection::with();
        }

        return $collection::withClosure(
            static function () use ($size, $collection) {
                $iterator = $collection->getIterator();

                while ($iterator->valid()) {
                    $values = [];

                    for ($i = 0; $iterator->valid() && $i < $size; $i++, $iterator->next()) {
                        $values[$iterator->key()] = $iterator->current();
                    }

                    yield $collection::withArray($values);
                }
            }
        );
    }
}

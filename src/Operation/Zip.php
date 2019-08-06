<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $items = $this->parameters;

        return $collection::withClosure(
            static function () use ($items, $collection) {
                $iterator = $collection->getIterator();

                /** @var \Iterator $itemsIterator */
                $itemsIterator = $collection::with($items)->getIterator();

                while ($iterator->valid()) {
                    yield [$iterator->current(), $itemsIterator->current()];

                    $itemsIterator->next();
                    $iterator->next();
                }
            }
        );
    }
}

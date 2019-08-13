<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $items = $this->parameters;

        return Collection::withClosure(
            static function () use ($items, $collection) {
                $iterator = $collection->getIterator();

                /** @var \Iterator $itemsIterator */
                $itemsIterator = Collection::with($items)->getIterator();

                while ($iterator->valid()) {
                    yield [$iterator->current(), $itemsIterator->current()];

                    $itemsIterator->next();
                    $iterator->next();
                }
            }
        );
    }
}

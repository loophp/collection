<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Flatten.
 */
final class Flatten extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$depth] = $this->parameters;

        return Collection::with(
            static function () use ($depth, $collection): \Generator {
                $iterator = $collection->getIterator();

                foreach ($iterator as $item) {
                    if (!\is_array($item) && !$item instanceof Collection) {
                        yield $item;
                    } elseif (1 === $depth) {
                        foreach ($item as $i) {
                            yield $i;
                        }
                    } else {
                        foreach (Flatten::with($depth - 1)->run(Collection::with($item)) as $flattenItem) {
                            yield $flattenItem;
                        }
                    }
                }
            }
        );
    }
}

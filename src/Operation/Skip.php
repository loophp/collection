<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Skip.
 */
final class Skip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$counts] = $this->parameters;

        return Collection::with(
            static function () use ($counts, $collection): \Generator {
                $iterator = $collection->getIterator();
                $counts = \array_sum($counts);

                foreach ($iterator as $key => $item) {
                    if (0 < $counts--) {
                        continue;
                    }

                    break;
                }

                if ($iterator->valid()) {
                    yield from $iterator;
                }
            }
        );
    }
}

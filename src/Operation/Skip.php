<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Skip.
 */
final class Skip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $counts = $this->parameters;

        return $collection::withClosure(
            static function () use ($counts, $collection) {
                $iterator = $collection->getIterator();
                $counts = array_sum($counts);

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

<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Limit.
 */
final class Limit extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $limit = $this->parameters[0];

        return $collection::withClosure(
            static function () use ($limit, $collection) {
                $iterator = $collection->getIterator();

                for (; (true === $iterator->valid()) && (0 !== $limit--); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            }
        );
    }
}

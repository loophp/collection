<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Limit.
 */
final class Limit extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $limit = $this->parameters[0];

        return Collection::with(
            static function () use ($limit, $collection): \Generator
            {
                $iterator = $collection->getIterator();

                for (; (true === $iterator->valid()) && (0 !== $limit--); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            }
        );
    }
}

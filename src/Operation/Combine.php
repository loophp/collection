<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Combine.
 */
final class Combine extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $keys = $this->parameters;

        return Collection::withClosure(
            static function () use ($keys, $collection) {
                $original = $collection->getIterator();
                $keysIterator = Collection::with($keys)->getIterator();

                for (; true === ($original->valid() && $keysIterator->valid()); $original->next(), $keysIterator->next()
                ) {
                    yield $keysIterator->current() => $original->current();
                }

                if (($original->valid() && !$keysIterator->valid()) ||
                    (!$original->valid() && $keysIterator->valid())
                ) {
                    \trigger_error('Both keys and values must have the same amount of items.', \E_USER_WARNING);
                }
            }
        );
    }
}

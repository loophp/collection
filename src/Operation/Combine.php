<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Combine.
 */
final class Combine extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$keys] = $this->parameters;

        return Collection::with(
            static function () use ($keys, $collection): \Generator {
                /** @var \Iterator $original */
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

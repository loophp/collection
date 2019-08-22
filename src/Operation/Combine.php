<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Combine.
 */
final class Combine extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$keys] = $this->parameters;

        return static function () use ($keys, $collection): \Generator {
            $original = $collection->getIterator();
            $keysIterator = $collection::with($keys)->getIterator();

            for (; true === ($original->valid() && $keysIterator->valid()); $original->next(), $keysIterator->next()
                ) {
                yield $keysIterator->current() => $original->current();
            }

            if (($original->valid() && !$keysIterator->valid()) ||
                    (!$original->valid() && $keysIterator->valid())
                ) {
                \trigger_error('Both keys and values must have the same amount of items.', \E_USER_WARNING);
            }
        };
    }
}

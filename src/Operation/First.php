<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class First.
 */
final class First extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection)
    {
        [$callback, $default] = $this->parameters;

        /** @var \Iterator $iterator */
        $iterator = $collection->getIterator();

        if (null === $callback) {
            if (!$iterator->valid()) {
                return $default;
            }

            return $iterator->current();
        }

        foreach ($iterator as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }
}

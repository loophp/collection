<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Apply.
 */
final class Apply extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$callback] = $this->parameters;

        $newCollection = Collection::with($collection);

        foreach ($newCollection as $key => $item) {
            if (false === $callback($item, $key)) {
                break;
            }
        }

        return $collection;
    }
}

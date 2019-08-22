<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Last.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Last extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection)
    {
        $reduced =
            new Reduce(
                static function ($carry, $item) {
                    return $item;
                },
                $collection->getIterator()->current()
            );

        return $reduced->run($collection);
    }
}

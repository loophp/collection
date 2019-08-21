<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class All.
 */
final class All extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection)
    {
        $result = [];

        foreach ($collection as $key => $item) {
            if ($item instanceof CollectionInterface) {
                $result[$key] = All::with()->run($item);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}

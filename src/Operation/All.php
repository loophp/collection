<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class All.
 */
final class All extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection)
    {
        $result = [];

        foreach ($collection as $key => $item) {
            if ($item instanceof BaseCollectionInterface) {
                $result[$key] = (new self())->run($item);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}

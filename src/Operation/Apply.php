<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Apply.
 */
final class Apply extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$callbacks] = $this->parameters;

        foreach ($callbacks as $callback) {
            foreach ($collection::with($collection) as $key => $item) {
                if (false === $callback($item, $key)) {
                    break;
                }
            }
        }

        return $collection;
    }
}

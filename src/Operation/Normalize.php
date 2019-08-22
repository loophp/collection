<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Normalize.
 */
final class Normalize extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        return static function () use ($collection) {
            foreach ($collection as $item) {
                yield $item;
            }
        };
    }
}

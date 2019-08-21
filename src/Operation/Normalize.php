<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Normalize.
 */
final class Normalize extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        return Collection::with(
            static function () use ($collection) {
                foreach ($collection as $item) {
                    yield $item;
                }
            }
        );
    }
}

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Prepend.
 */
final class Prepend extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$items] = $this->parameters;

        return Collection::with(
            static function () use ($items, $collection): \Generator {
                foreach ($items as $item) {
                    yield $item;
                }

                foreach ($collection as $item) {
                    yield $item;
                }
            }
        );
    }
}

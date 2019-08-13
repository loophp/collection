<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Prepend.
 */
final class Prepend extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $items = $this->parameters;

        return Collection::withClosure(
            static function () use ($items, $collection) {
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

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Append.
 */
final class Append extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$items] = $this->parameters;

        return Collection::with(
            static function () use ($items, $collection): \Generator
            {
                foreach ($collection as $item) {
                    yield $item;
                }

                foreach ($items as $item) {
                    yield $item;
                }
            }
        );
    }
}

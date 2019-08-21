<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Collapse.
 */
final class Collapse extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        return Collection::with(
            static function () use ($collection): \Generator
            {
                foreach ($collection as $item) {
                    if (\is_array($item) || $item instanceof CollectionInterface) {
                        foreach ($item as $value) {
                            yield $value;
                        }
                    }
                }
            }
        );
    }
}

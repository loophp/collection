<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Merge.
 */
final class Merge extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$sources] = $this->parameters;

        return Collection::with(
            static function () use ($sources, $collection): \Generator {
                foreach ($collection as $item) {
                    yield $item;
                }

                foreach ($sources as $source) {
                    foreach ($source as $item) {
                        yield $item;
                    }
                }
            }
        );
    }
}

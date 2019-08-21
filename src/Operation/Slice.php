<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Slice.
 */
final class Slice extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$offset, $length] = $this->parameters;

        return Collection::with(
            static function () use ($offset, $length, $collection): \Generator {
                if (null === $length) {
                    yield from Skip::with([$offset])->run($collection);
                } else {
                    yield from Limit::with($length)->run(Skip::with([$offset])->run($collection));
                }
            }
        );
    }
}

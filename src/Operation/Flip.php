<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Flip.
 */
final class Flip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        return Collection::with(
            static function () use ($collection): \Generator {
                foreach ($collection as $key => $value) {
                    yield $value => $key;
                }
            }
        );
    }
}

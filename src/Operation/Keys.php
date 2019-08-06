<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Keys.
 */
final class Keys extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        return $collection::withClosure(
            static function () use ($collection) {
                foreach ($collection as $key => $value) {
                    yield $key;
                }
            }
        );
    }
}

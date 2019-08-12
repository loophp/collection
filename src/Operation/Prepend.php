<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Prepend.
 */
final class Prepend extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $items = $this->parameters;

        return $collection::withClosure(
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

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Append.
 */
final class Append extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $items = $this->parameters;

        return $collection::withClosure(
            static function () use ($items, $collection) {
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

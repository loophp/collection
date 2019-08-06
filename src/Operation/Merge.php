<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Merge.
 */
final class Merge extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $sources = $this->parameters;

        return $collection::withClosure(
            static function () use ($sources, $collection) {
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

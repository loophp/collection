<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Collapse.
 */
final class Collapse extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        return $collection::withClosure(
            static function () use ($collection) {
                foreach ($collection as $values) {
                    if (\is_array($values) || $values instanceof Collection) {
                        yield from $values;
                    }
                }
            }
        );
    }
}

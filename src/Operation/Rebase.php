<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Rebase.
 */
final class Rebase implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        return static function () use ($collection) {
            yield from $collection;
        };
    }
}

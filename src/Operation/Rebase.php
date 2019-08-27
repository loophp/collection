<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Rebase.
 */
final class Rebase extends Operation
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

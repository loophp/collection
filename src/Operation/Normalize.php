<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Normalize.
 */
final class Normalize extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        return static function () use ($collection) {
            foreach ($collection as $item) {
                yield $item;
            }
        };
    }
}

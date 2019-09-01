<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Normalize.
 */
final class Normalize implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        return static function () use ($collection) {
            foreach ($collection as $value) {
                yield $value;
            }
        };
    }
}

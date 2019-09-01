<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Flip.
 */
final class Flip implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        return static function () use ($collection): \Generator {
            foreach ($collection as $key => $value) {
                yield $value => $key;
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Normalize.
 */
final class Normalize implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        return static function () use ($collection): Generator {
            foreach ($collection as $value) {
                yield $value;
            }
        };
    }
}

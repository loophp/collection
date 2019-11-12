<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Collapse.
 */
final class Collapse implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        return static function () use ($collection): Generator {
            foreach ($collection as $value) {
                if (true === is_iterable($value)) {
                    foreach ($value as $subValue) {
                        yield $subValue;
                    }
                }
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Collapse.
 */
final class Collapse extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        return static function () use ($collection): \Generator {
            foreach ($collection as $value) {
                if (true === \is_iterable($value)) {
                    foreach ($value as $subValue) {
                        yield $subValue;
                    }
                }
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Append.
 */
final class Append extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$items] = $this->parameters;

        return static function () use ($items, $collection): \Generator {
            foreach ($collection as $value) {
                yield $value;
            }

            foreach ($items as $item) {
                yield $item;
            }
        };
    }
}

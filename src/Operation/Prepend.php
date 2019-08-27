<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Prepend.
 */
final class Prepend extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$items] = $this->parameters;

        return static function () use ($items, $collection): \Generator {
            foreach ($items as $item) {
                yield $item;
            }

            foreach ($collection as $item) {
                yield $item;
            }
        };
    }
}

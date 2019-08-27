<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Merge.
 */
final class Merge extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$sources] = $this->parameters;

        return static function () use ($sources, $collection): \Generator {
            foreach ($collection as $item) {
                yield $item;
            }

            foreach ($sources as $source) {
                foreach ($source as $item) {
                    yield $item;
                }
            }
        };
    }
}

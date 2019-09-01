<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Prepend.
 */
final class Prepend implements Operation
{
    /**
     * @var array
     */
    private $items;

    /**
     * Prepend constructor.
     *
     * @param mixed ...$items
     */
    public function __construct(...$items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$items] = $this->items;

        return static function () use ($items, $collection): \Generator {
            foreach ($items as $item) {
                yield $item;
            }

            foreach ($collection as $value) {
                yield $value;
            }
        };
    }
}

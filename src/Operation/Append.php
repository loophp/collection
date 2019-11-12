<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Append.
 */
final class Append implements Operation
{
    /**
     * @var array|mixed[]
     */
    private $items;

    /**
     * Append constructor.
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
    public function on(iterable $collection): Closure
    {
        [$items] = $this->items;

        return static function () use ($items, $collection): Generator {
            foreach ($collection as $value) {
                yield $value;
            }

            foreach ($items as $item) {
                yield $item;
            }
        };
    }
}

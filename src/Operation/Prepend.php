<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Prepend.
 */
final class Prepend implements Operation
{
    /**
     * @var array<mixed, mixed>
     */
    private $items;

    /**
     * Prepend constructor.
     *
     * @param array<mixed, mixed> ...$items
     */
    public function __construct(...$items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $items = $this->items;

        return static function (iterable $collection) use ($items): Generator {
            foreach ($items as $item) {
                yield $item;
            }

            foreach ($collection as $value) {
                yield $value;
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

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
    public function __invoke(): Closure
    {
        $items = $this->items;

        return static function (iterable $collection) use ($items): Generator {
            foreach ($collection as $value) {
                yield $value;
            }

            foreach ($items as $item) {
                yield $item;
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Append extends AbstractOperation implements Operation
{
    /**
     * Append constructor.
     *
     * @param mixed ...$items
     */
    public function __construct(...$items)
    {
        $this->storage['items'] = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $items): Generator {
            foreach ($collection as $value) {
                yield $value;
            }

            foreach ($items as $item) {
                yield $item;
            }
        };
    }
}

<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Prepend extends AbstractOperation implements Operation
{
    /**
     * Prepend constructor.
     *
     * @param mixed ...$items
     */
    public function __construct(...$items)
    {
        $this->storage['items'] = $items;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, mixed> $items
             * @param iterable $collection
             */
            static function (iterable $collection, array $items): Generator {
                foreach ($items as $item) {
                    yield $item;
                }

                foreach ($collection as $value) {
                    yield $value;
                }
            };
    }
}

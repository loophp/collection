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
             */
            static function (iterable $collection, array $items): Generator {
                foreach ($items as $key => $item) {
                    yield $key => $item;
                }

                foreach ($collection as $key => $value) {
                    yield $key => $value;
                }
            };
    }
}

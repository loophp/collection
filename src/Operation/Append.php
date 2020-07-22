<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
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

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, mixed> $items
             */
            static function (Iterator $iterator, array $items): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => $value;
                }

                foreach ($items as $key => $item) {
                    yield $key => $item;
                }
            };
    }
}

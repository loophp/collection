<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

final class Diff extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = $values;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, mixed> $values
             */
            static function (Iterator $iterator, $values): Generator {
                foreach ($iterator as $key => $value) {
                    if (false === in_array($value, $values, true)) {
                        yield $key => $value;
                    }
                }
            };
    }
}

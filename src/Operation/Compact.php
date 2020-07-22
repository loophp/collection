<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

use function in_array;

final class Compact extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = [] === $values ? [null] : $values;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, mixed> $values
             */
            static function (Iterator $iterator, $values): Generator {
                return yield from
                (new Run(
                    new Filter(
                        /**
                         * @param mixed $item
                         */
                        static function ($item) use ($values): bool {
                            return !in_array($item, $values, true);
                        }
                    )
                )
                )($iterator);
            };
    }
}

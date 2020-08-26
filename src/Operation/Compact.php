<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Compact extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (...$values): Closure {
            return static function (Iterator $iterator) use ($values): Generator {
                $values = [] === $values ? [null] : $values;

                $filter = (new Filter())()(
                    /**
                     * @param mixed $item
                     */
                    static function ($item) use ($values): bool {
                        return !in_array($item, $values, true);
                    }
                );

                return yield from (new Run())()($filter)($iterator);
            };
        };
    }
}

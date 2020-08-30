<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Times extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $number = 0): Closure {
            return static function (?callable $callback = null) use ($number): Closure {
                return static function (Iterator $iterator) use ($number, $callback): Generator {
                    if (1 > $number) {
                        throw new InvalidArgumentException('Invalid parameter. $number must be greater than 1.');
                    }

                    $callback = $callback ?? static function (int $value): int {
                        return $value;
                    };

                    for ($current = 1; $current <= $number; ++$current) {
                        yield $callback($current);
                    }
                };
            };
        };
    }
}

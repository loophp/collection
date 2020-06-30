<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use loophp\collection\Contract\Operation;

final class Times extends AbstractOperation implements Operation
{
    /**
     * Times constructor.
     */
    public function __construct(int $number = 0, ?callable $callback = null)
    {
        if (1 > $number) {
            throw new InvalidArgumentException('Invalid parameter. $number must be greater than 1.');
        }

        $this->storage = [
            'number' => $number,
            'callback' => $callback ?? static function (int $value): int {
                return $value;
            },
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param float|int $number
             */
            static function (iterable $collection, $number, callable $callback): Generator {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $callback($current);
                }
            };
    }
}

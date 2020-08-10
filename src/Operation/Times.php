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
 *
 * @implements Operation<TKey, T>
 */
final class Times extends AbstractGeneratorOperation implements Operation
{
    public function __construct(?int $number = null, ?callable $callback = null)
    {
        $number = $number ?? 0;

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
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param callable(int):(int) $callback
             *
             * @psalm-return \Generator<int, int>
             */
            static function (Iterator $iterator, ?int $number, callable $callback): Generator {
                for ($current = 1; $current <= $number; ++$current) {
                    yield $callback($current);
                }
            };
    }
}

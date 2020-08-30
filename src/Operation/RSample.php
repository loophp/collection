<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class RSample extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (float $probability): Closure {
            return static function (Iterator $iterator) use ($probability): Generator {
                $callback = static function () use ($probability): bool {
                    return (mt_rand() / mt_getrandmax()) < $probability;
                };

                return yield from Filter::of()($callback)($iterator);
            };
        };
    }
}

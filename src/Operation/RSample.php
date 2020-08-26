<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class RSample extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (float $probability): Closure {
            return static function (Iterator $iterator) use ($probability): Generator {
                $filter = (new Filter())()(
                    static function () use ($probability): bool {
                        return (mt_rand() / mt_getrandmax()) < $probability;
                    }
                );

                return yield from (new Run())()($filter)($iterator);
            };
        };
    }
}

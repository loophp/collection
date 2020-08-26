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
final class Explode extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (...$explodes): Closure {
            return static function (Iterator $iterator) use ($explodes): Generator {
                $split = (new Split())()(
                    ...array_map(
                        /**
                         * @param mixed $explode
                         * @psalm-param T $explode
                         */
                        static function ($explode): Closure {
                            return
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 */
                                static function ($value) use ($explode): bool {
                                    return $value === $explode;
                                };
                        },
                        $explodes
                    )
                );

                return yield from (new Run())()($split)($iterator);
            };
        };
    }
}

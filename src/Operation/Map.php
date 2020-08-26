<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Map extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (callable ...$callbacks): Closure {
            return static function (Iterator $iterator) use ($callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    $callback =
                        /**
                         * @param mixed $carry
                         * @psalm-param T $carry
                         * @psalm-param callable(T, TKey): T $callback
                         * @psalm-return T
                         */
                        static function ($carry, callable $callback) use ($value, $key) {
                            return $callback($value, $key);
                        };

                    yield $key => array_reduce($callbacks, $callback, $value);
                }
            };
        };
    }
}

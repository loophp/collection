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
final class Until extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure((callable(T, TKey):(bool))...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey):(bool) ...$callbacks
             */
            static function (callable ...$callbacks): Closure {
                return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    foreach ($iterator as $key => $value) {
                        yield $key => $value;

                        $result = array_reduce(
                            $callbacks,
                            static function (bool $carry, callable $callable) use ($key, $value): bool {
                                return ($callable($value, $key)) ?
                                $carry :
                                false;
                            },
                            true
                        );

                        if (false !== $result) {
                            break;
                        }
                    }
                };
            };
    }
}

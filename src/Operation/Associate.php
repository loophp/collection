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
final class Associate extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(null|callable(TKey, T):(TKey)): Closure(null|callable(TKey, T):(T)): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param null|callable(TKey, T):(TKey) $callbackForKeys
             */
            static function (?callable $callbackForKeys = null): Closure {
                $callbackForKeys = $callbackForKeys ?? static function ($key, $value) {
                    return $key;
                };

                return
                    /**
                     * @psalm-param null|callable(TKey, T):(T) $callbackForValues
                     */
                    static function (?callable $callbackForValues = null) use ($callbackForKeys): Closure {
                        $callbackForValues = $callbackForValues ?? static function ($key, $value) {
                            return $value;
                        };

                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                                foreach ($iterator as $key => $value) {
                                    yield $callbackForKeys($key, $value) => $callbackForValues($key, $value);
                                }
                            };
                    };
            };
    }
}

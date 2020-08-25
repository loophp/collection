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
     * @psalm-param null|callable(TKey, T):(TKey) $callbackForKeys
     * @psalm-param null|callable(TKey, T):(T) $callbackForValues
     */
    public function __construct(?callable $callbackForKeys = null, ?callable $callbackForValues = null)
    {
        $this->storage = [
            'callbackForKeys' => $callbackForKeys ?? static function ($key, $value) {
                return $key;
            },
            'callbackForValues' => $callbackForValues ?? static function ($key, $value) {
                return $value;
            },
        ];
    }

    /**
     * @psalm-return Closure(Iterator<TKey, T>, callable(TKey, T):(TKey), callable(TKey, T):(T)):(Generator<TKey, T>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-param callable(TKey, T):(TKey) $callbackForKeys
             * @psalm-param callable(TKey, T):(T) $callbackForValues
             */
            static function (Iterator $iterator, callable $callbackForKeys, callable $callbackForValues): Generator {
                foreach ($iterator as $key => $value) {
                    yield $callbackForKeys($key, $value) => $callbackForValues($key, $value);
                }
            };
    }
}

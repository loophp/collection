<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template T
 * @psalm-template T of array-key
 */
final class Flip extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<T, TKey>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys = static fn ($carry, $key, $value) => $value;
        $callbackForValues = static fn ($carry, $key, $value) => $key;

        /**
         * @var Closure(Iterator<TKey, T>): Generator<T, TKey>
         */
        $associate = Associate::of()($callbackForKeys)($callbackForValues);

        // Point free style.
        return $associate;
    }
}

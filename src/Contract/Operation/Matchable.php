<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

use Iterator;

/**
 * @template TKey
 * @template T
 */
interface Matchable
{
    /**
     * Check if the collection matches a given `user callback`.
     * You must provide a callback that can get the `key`, the `current value`, and the `iterator` as parameters.
     * When no matcher callback is provided, the user callback must return `true`
     * (the default value of the matcher callback) in order to stop.
     *
     * The returned value of the operation is `true` when the callback matches at least
     * one element of the collection, `false` otherwise.
     * If you want to match the `user callback` against another value (other than `true`),
     * you must provide your own `matcher callback` as a second argument, and it must return a `boolean`.
     *
     * @see https://loophp-collection.readthedocs.io/en/stable/pages/api.html#match
     *
     * @param callable(T, TKey, iterable<TKey, T>): bool $callback
     * @param null|callable(T, TKey, iterable<TKey, T>): bool $matcher
     */
    public function match(callable $callback, ?callable $matcher = null): bool;
}

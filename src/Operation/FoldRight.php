<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FoldRight implements Operation
{
    /**
     * @pure
     *
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>):(T|null)): Closure(T): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(T): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $callback): Closure => static function ($initial = null) use ($callback): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                $pipe = Pipe::of()(
                    ScanRight::of()($callback)($initial),
                    Head::of()
                );

                // Point free style.
                return $pipe;
            };
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}

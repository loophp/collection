<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
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
final class Pipe implements Operation
{
    /**
     * @pure
     *
     * @param callable(Iterator<TKey, T>): Iterator<TKey, T> ...$operations
     *
     * @return Closure(callable(Iterator<TKey, T>): Iterator<TKey, T> ...): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(callable ...$operations): Closure
    {
        return array_reduce(
            $operations,
            /**
             * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $f
             * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $g
             *
             * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable $f, callable $g): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => $g($f($iterator)),
            static fn (Iterator $iterator): Iterator => $iterator
        );
    }

    /**
     * @pure
     *
     * @template A
     * @template B
     *
     * @param callable(A): B $op1
     *
     * @return Closure(A): B
     */
    public static function ofTyped1(callable $op1): Closure
    {
        return (new Pipe())()($op1);
    }

    /**
     * @pure
     *
     * @template A
     * @template B
     * @template C
     *
     * @param callable(A): B $op1
     * @param callable(B): C $op2
     *
     * @return Closure(A): C
     */
    public static function ofTyped2(callable $op1, callable $op2): Closure
    {
        return (new Pipe())()($op1, $op2);
    }

    /**
     * @pure
     *
     * @template A
     * @template B
     * @template C
     * @template D
     *
     * @param callable(A): B $op1
     * @param callable(B): C $op2
     * @param callable(C): D $op3
     *
     * @return Closure(A): D
     */
    public static function ofTyped3(callable $op1, callable $op2, callable $op3): Closure
    {
        return (new Pipe())()($op1, $op2, $op3);
    }

    /**
     * @pure
     *
     * @template A
     * @template B
     * @template C
     * @template D
     * @template E
     *
     * @param callable(A): B $op1
     * @param callable(B): C $op2
     * @param callable(C): D $op3
     * @param callable(D): E $op4
     *
     * @return Closure(A): E
     */
    public static function ofTyped4(callable $op1, callable $op2, callable $op3, callable $op4): Closure
    {
        return (new Pipe())()($op1, $op2, $op3, $op4);
    }

    /**
     * @pure
     *
     * @template A
     * @template B
     * @template C
     * @template D
     * @template E
     * @template F
     *
     * @param callable(A): B $op1
     * @param callable(B): C $op2
     * @param callable(C): D $op3
     * @param callable(D): E $op4
     * @param callable(E): F $op5
     *
     * @return Closure(A): F
     */
    public static function ofTyped5(callable $op1, callable $op2, callable $op3, callable $op4, callable $op5): Closure
    {
        return (new Pipe())()($op1, $op2, $op3, $op4, $op5);
    }
}

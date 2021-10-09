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
 */
final class Coalesce implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Compact::of()(),
            Head::of(),
        );

        // Point free style.
        return $pipe;
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}

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
final class Keys implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, TKey>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, T>): Generator<int, TKey> $pipe */
        $pipe = Pipe::of()(
            Flip::of(),
            Normalize::of()
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

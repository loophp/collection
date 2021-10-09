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
final class Pack implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return array{0: TKey, 1: T}
             */
            static fn ($value, $key): array => [$key, $value];

        /** @var Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}> $pipe */
        $pipe = Pipe::of()(
            Map::of()($mapCallback),
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

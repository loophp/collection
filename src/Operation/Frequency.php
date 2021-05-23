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

/**
 * @template TKey of array-key
 * @template T
 */
final class Frequency extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        $reduceCallback =
            /**
             * @psalm-param array<int, array{0: int, 1: T}> $storage
             * @psalm-param T $value
             *
             * @psalm-return array<int, array{0: int, 1: T}>
             *
             * @param mixed $value
             */
            static function (array $storage, $value): array {
                $added = false;

                foreach ($storage as $key => $data) {
                    if ($data[1] !== $value) {
                        continue;
                    }

                    ++$storage[$key][0];
                    $added = true;

                    break;
                }

                if (false !== $added) {
                    return $storage;
                }

                $storage[] = [1, $value];

                return $storage;
            };

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, T> $pipe */
        $pipe = Pipe::of()(
            FoldLeft::of()($reduceCallback)([]),
            Flatten::of()(1),
            Unpack::of()
        );

        // Point free style.
        return $pipe;
    }
}

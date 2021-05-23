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
final class Distinct extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        $foldLeftCallback =
            /**
             * @psalm-param list<array{0: TKey, 1: T}> $seen
             *
             * @psalm-param array{0: TKey, 1: T} $value
             */
            static function (array $seen, array $value): array {
                $isSeen = false;

                foreach ($seen as $item) {
                    if ($item[1] === $value[1]) {
                        $isSeen = true;

                        break;
                    }
                }

                if (false === $isSeen) {
                    $seen[] = $value;
                }

                return $seen;
            };

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Pack::of(),
            FoldLeft::of()($foldLeftCallback)([]),
            Unwrap::of(),
            Unpack::of()
        );

        // Point free style.
        return $pipe;
    }
}

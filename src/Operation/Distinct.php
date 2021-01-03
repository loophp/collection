<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
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
             * @psalm-param array<int, list<array{0:TKey, 1:T}>> $seen
             * @psalm-param array{0:TKey, 1:T} $value
             *
             * @psalm-return array<int, list<array{0:TKey, 1:T}>>
             */
            static function (array $seen, array $value): array {
                $return = false;

                foreach ($seen as $seenTuple) {
                    if ($seenTuple[1] === $value[1]) {
                        $return = true;
                        break;
                    }
                }

                if (false === $return) {
                    $seen[] = $value;
                }

                return $seen;
            };

        $pipe = Pipe::of()(
            Pack::of(),
            FoldLeft::of()($foldLeftCallback)([]),
            Unwrap::of(),
            Unpack::of(),
        );

        // Point free style.
        return $pipe;
    }
}

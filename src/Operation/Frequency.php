<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Frequency extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        $reduceCallback =
            /**
             * @param array<int, array{0: int, 1: T}> $storage
             * @param T $value
             *
             * @return array<int, array{0: int, 1: T}>
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

                if (true !== $added) {
                    $storage[] = [1, $value];
                }

                return $storage;
            };

        /** @var Closure(iterable<TKey, T>): Generator<int, T> $pipe */
        $pipe = (new Pipe())()(
            (new Reduce())()($reduceCallback)([]),
            (new Flatten())()(1),
            (new Unpack())()
        );

        // Point free style.
        return $pipe;
    }
}

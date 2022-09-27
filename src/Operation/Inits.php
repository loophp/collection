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
final class Inits extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, list<array{0: TKey, 1: T}>> $inits */
        $inits = (new Pipe())()(
            (new Pack())(),
            (new ScanLeft())()(
                /**
                 * @param list<array{0: TKey, 1: T}> $carry
                 * @param array{0: TKey, 1: T} $value
                 *
                 * @return list<array{0: TKey, 1: T}>
                 */
                static function (array $carry, array $value): array {
                    $carry[] = $value;

                    return $carry;
                }
            )([]),
            (new Normalize())()
        );

        // Point free style.
        return $inits;
    }
}

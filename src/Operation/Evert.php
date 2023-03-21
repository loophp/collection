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
final class Evert extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, iterable<TKey, T>>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        $reArrange = static function (iterable $iterable): Generator {
            foreach ($iterable as $k1 => $v1) {
                foreach ($v1 as $k2 => $v2) {
                    yield $v2 => [$k2, $k1];
                }
            }
        };

        $groupBy = static fn (array $_, mixed $v2): mixed => $v2;

        $pipe = (new Pipe())()(
            $reArrange,
            (new GroupBy())()($groupBy),
        );

        return $pipe;
    }
}

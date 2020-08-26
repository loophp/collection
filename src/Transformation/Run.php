<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Run implements Transformation
{
    public function __invoke(): Closure
    {
        return static function (callable ...$operations): Closure {
            return static function (Iterator $iterator) use ($operations) {
                return (new FoldLeft())()(
                    static function (Iterator $collection, callable $operation): ClosureIterator {
                        return new ClosureIterator(
                            $operation,
                            $collection,
                        );
                    }
                )($iterator)($operations);
            };
        };
    }
}

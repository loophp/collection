<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Group extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int, list<T>>
             */
            static function (Iterator $iterator): Generator {
                $last = [];

                foreach ($iterator as $current) {
                    if ([] === $last) {
                        $last = [$current];

                        continue;
                    }

                    if (current($last) === $current) {
                        $last[] = $current;

                        continue;
                    }

                    yield $last;

                    $last = [$current];
                }

                if ([] !== $last) {
                    yield $last;
                }
            };
    }
}
